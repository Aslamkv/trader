new Vue({
  el: '#app',
  data() {
    return {
      stock_to_analyse:'',
      from_date: new Date(),
      to_date: new Date(),
      stock_file:false,
      filename:'',
      processing:false,
      analysis:false,
      error:false,
      no_of_shares:1
    }
  },
  mounted() {
    this.initialize_datepicker()
    this.initialize_stock_suggestion()
  },
  computed:{
    disabled(){
      if(this.processing)
        return true
      if(!this.stock_to_analyse)
        return true
      if(!this.stock_file)
        return true
      if(!this.from_date)
        return true
      if(!this.to_date)
        return true
    },
    has_analysis(){
      if(this.analysis){
        return this.analysis.buying_and_selling_dates.length>0
      }
      return false
    },
    no_profit_available(){
      if(this.analysis){
        return this.analysis.buying_and_selling_dates.length<1
      }
      return false
    }
  },
  methods:{
    initialize_datepicker(){
      const calendar = bulmaCalendar.attach(this.$refs.calendarTrigger, {
        startDate: this.from_date,
        endDate: this.to_date,
        type:'date',
        dateFormat:'DD/MM/YYYY',
        isRange:true,
        color:'danger'
      })[0]
      calendar.on('select', e => {
        this.from_date = e.data.startDate || null
        this.to_date = e.data.endDate || null
      })
      calendar.on('clear',e=>{
        this.from_date=false
        this.to_date=false
      })
    },
    initialize_stock_suggestion(){
      const api = function(inputValue) {
        return fetch('js/stocks.json')
        .then(function(resp) {
          return resp.json()
        }).then(function(stocks) {
          return stocks.filter(function(stock) {
            return stock.value.toLowerCase().startsWith(inputValue.toLowerCase())
          })
        }).then(function(filtered) {
          return filtered.map(function(stock) {
            return {label: `${stock.label} (${stock.value})`, value: stock.value}
          })
        }).then(function(transformed) {
          return transformed.slice(0, 5)
        })
      }
      const onSelect=(e)=>{
        this.stock_to_analyse=e.value
      }
      bulmahead(
        'stock',
        'stock-menu',
        api,
        onSelect,
        200
      )
    },
    getDateInDayMonthYearFormat(custom_date){
      let date=custom_date.getDate().toString().padStart(2,0)
      let month=(custom_date.getMonth()+1).toString().padStart(2,0)
      let year=custom_date.getFullYear()
      return `${date}-${month}-${year}`
    },
    processFile(e){
      if(e.target.files.length){
        this.stock_file=e.target.files[0]
        this.filename=e.target.files[0].name
      }
    },
    analyse(){
      if(this.processing)
        return false

      this.processing=true
      this.analysis=false
      this.error=false

      let data=new FormData()
      data.append('stock_to_analyse',this.stock_to_analyse)
      data.append('from_date',this.getDateInDayMonthYearFormat(this.from_date))
      data.append('to_date',this.getDateInDayMonthYearFormat(this.to_date))
      data.append('stock_file',this.stock_file)

      fetch('/api.php',{
        method:'post',
        body:data
      }).then(this.handle_errors)
      .then(r=>r.json())
      .then(analysis=>this.analysis=analysis)
      .catch(error=>{
        this.error=error
      }).finally(()=>this.processing=false)
    },
    handle_errors(response){
      if(!response.ok){
        response.json().then(e=>this.error=e.error)
        throw new Error(response.statusText)
      }
      return response
    }
  }
})
