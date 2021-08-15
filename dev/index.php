<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Trader</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="css/bulma.min.css">
    <link rel="stylesheet" href="css/bulma-calendar.min.css">
    <link rel="stylesheet" href="css/custom.css">
  </head>
  <body>
    <div id="app">
      <section class="hero is-danger">
        <div class="hero-body">
          <figure class="image is-128x128">
            <img src="img/logo.png">
          </figure>
          <p class="title">
            Trader
          </p>
          <p class="subtitle">
            GUI application to analyse stock trading
          </p>
        </div>
      </section>
      <div class="container">
        <div class="field">
          <label class="label">Stock To Analyse</label>
          <div class="dropdown">
            <div class="dropdown-trigger">
              <input
                id="stock"
                class="input"
                type="text"
                placeholder="Enter Stock Name"
                aria-haspopup="true"
                aria-controls="prova-menu" />
            </div>
            <div class="dropdown-menu" id="stock-menu" role="menu" />
          </div>
        </div>
        <div class="field">
          <label class="label">Stock List</label>
          <div class="file has-name">
            <label class="file-label">
              <input
                class="file-input"
                type="file"
                name="stock_list"
                @change="processFile"
                accept=".csv">
              <span class="file-cta">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>
                <span class="file-label">
                  Choose a CSV file…
                </span>
              </span>
              <span class="file-name">
                {{filename}}
              </span>
            </label>
          </div>
        </div>
        <div class="field">
          <label class="label">Date Range</label>
          <button ref='calendarTrigger' type='button'>Change</button>
        </div>
        <div class="field">
          <div class="control">
            <button
              class="button is-danger"
              :class="{'is-loading':processing}"
              @click="analyse"
              :disabled="disabled">
              Analyse
            </button>
          </div>
        </div>
      </div>
      <div class="container">
        <div v-if="has_analysis" class="section">
          <table class="table is-bordered">
            <thead>
              <tr>
                <th>Buying Date</th>
                <th>Selling Date</th>
                <th>Profit</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(entry,index) in analysis.buying_and_selling_dates"
                key="index">
                <td>{{entry.buying_date}}</td>
                <td>{{entry.selling_date}}</td>
                <td>{{entry.profit}}</td>
              </tr>
            </tbody>
          </table>
          <div class="tags has-addons">
            <span class="tag is-medium">Mean</span>
            <span class="tag is-medium is-danger">{{analysis.mean}}</span>
          </div>
          <div class="tags has-addons">
            <span class="tag is-medium">Standard Deviation</span>
            <span class="tag is-medium is-danger">{{analysis.standard_deviation}}</span>
          </div>
          <div class="tags has-addons">
            <span class="tag is-medium">Total Profit</span>
            <span class="tag is-medium is-danger">{{analysis.total_profit}}</span>
          </div>
        </div>
        <div v-if="no_profit_available" class="section">
          <div class="notification is-danger">
            There is no profit available with the chosen criteria!
          </div>
        </div>
        <div v-if="error" class="section">
          <div class="notification is-danger">
            {{error}}
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="js/vue.min.js" charset="utf-8"></script>
  <script src="js/bulma-calendar.min.js" charset="utf-8"></script>
  <script src="js/bulmahead.bundle.js" charset="utf-8"></script>
  <script src="js/app.js" charset="utf-8"></script>
</html>
