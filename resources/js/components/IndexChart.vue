<template>
  <div>
    <line-chart :data="getChartData()" :options="getOptions()"></line-chart>
  </div>
</template>

<script>
import LineChart from "./LineChart";

export default {
  components: {
    LineChart
  },
  props: {
    chartdata: Object,
    month: String
  },
  data() {
    return {
        first_day : '',
        last_day : '',
        sum_hours: '',
    }
  },
  created: function () {
      this.first_day = this.$moment(this.month,'YYYY-MM-DD').startOf('month').format('YYYY-MM-DD');
      this.last_day = this.$moment(this.month,'YYYY-MM-DD').endOf('month').format('YYYY-MM-DD');
  },
  mounted : function(){
      let last_key = Object.keys(this.chartdata.sum).length -1;
      this.sum_hours = this.chartdata.sum[last_key];
      var ctx = document.getElementById("line-chart").getContext("2d");
      ctx.canvas.parentNode.style.backgroundColor = '#fff';
      ctx.canvas.style.height = '250px';
  },
  methods: {
    getChartData() {
      return {
        labels:  this.chartdata.day,
        datasets: [
          {
            data: this.chartdata.sum,
            borderColor: "#3280f57e",
            backgroundColor: "#3280f528",
            lineTension: 0,
            fill: true,
          }
        ]
      };
    },
    getOptions() {
      return {
        spanGaps: true,
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        animation: {
            // アニメーションにかかる秒数(ミリ秒)
            duration: 0,
        },
        hover: {
            // ホバーした際のツールチップなどの出方に関わる
            animationDuration: 0
        },
        //レスポンシブ中のアニメーション、0にするとパフォーマンス良し
        responsiveAnimationDuration: 0,
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day'
                },
                ticks: {
                    min: this.first_day,
                    max: this.last_day,
                }
            }],
            yAxes: [{
                ticks: {
                   min: 0
                },
                scaleLabel: {
                    display: true,
                    labelString: '総時間 (h)',
                }
            }],
        }
      }
    }
  }
};
</script>