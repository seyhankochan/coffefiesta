<!DOCTYPE html>
<html lang="en">
<?php
session_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['Kullanici'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Tek bir bağlantı yeterli
$link = mysqli_connect("localhost", "root", "", "proje");

// Bağlantı oluşturulamazsa hata göster
if (!$link) {
    die("Veritabanına bağlanılamadı: " . mysqli_connect_error());
}
?>
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Now UI Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <?php
    require "sidebar.php";
    require "navbar.php";
    ?>
    <style>
    /* İstenilen boyutları ve diğer stilleri ayarlayın */
    .chart-box {
        border: 1px solid #ddd; /* Sınır ekleyebilirsiniz */
        border-radius: 30px;
        width: 500px;
        height: 400px; /* İstenilen yüksekliği ayarlayın */
        overflow: hidden; /* İstenen davranışa göre overflow'yi ayarlayın */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa; /* İstenilen arkaplan rengini ayarlayın */
        margin-bottom: 10px; /* Grafiğin altındaki boşluğu ayarlayın */
        margin-left: 8px;
        margin-top: 8px;
    }

    /* Grafiği saran div'ı ortalamak için flex kullanabilirsiniz */
    #chartContainer1,
    #chartContainer2,
    #chartContainer3 {
        width: 80%; /* Grafiğin genişliğini ayarlayın */
        height: 80%; /* Grafiğin yüksekliğini ayarlayın */
    }
</style>

</head>

<body class="">
    <div class="panel-header panel-header-lg">
    <div id="container" style="height: 100%"></div>
    </div>
    <div class="row">
    <!-- Grafiği saran div ekleyin -->
    <div class="col-md-4">
        <div class="chart-box">
            <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="chart-box">
            <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="chart-box">
            <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
    <div class="col-md-4">
    <div class="chart-box">
        <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
    </div>
</div>

    <div class="col-md-4">
        <div class="chart-box">
            <div id="chartContainer5" style="height: 370px; width: 100%;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="chart-box">
            <div id="chartContainer6" style="height: 570px; width: 100%;"></div>
        </div>
    </div>
</div>
<?php
    require "footer.php";
    ?>
    </div>
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.1.2/dist/echarts.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
    <script src="../assets/demo/demo.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <script type="text/javascript">
    var dom = document.getElementById('container');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    let base = +new Date(1968, 9, 3);
let oneDay = 24 * 3600 * 1000;
let date = [];
let data = [Math.random() * 300];
for (let i = 1; i < 20000; i++) {
  var now = new Date((base += oneDay));
  date.push([now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'));
  data.push(Math.round((Math.random() - 0.5) * 20 + data[i - 1]));
}
option = {
  tooltip: {
    trigger: 'axis',
    position: function (pt) {
      return [pt[0], '10%'];
    }
  },
  title: {
    left: 'center',
    text: 'Large Area Chart'
  },
  toolbox: {
    feature: {
      dataZoom: {
        yAxisIndex: 'none'
      },
      restore: {},
      saveAsImage: {}
    }
  },
  xAxis: {
    type: 'category',
    boundaryGap: false,
    data: date
  },
  yAxis: {
    type: 'value',
    boundaryGap: [0, '100%']
  },
  dataZoom: [
    {
      type: 'inside',
      start: 0,
      end: 10
    },
    {
      start: 0,
      end: 10
    }
  ],
  series: [
    {
      name: 'Fake Data',
      type: 'line',
      symbol: 'none',
      sampling: 'lttb',
      itemStyle: {
        color: 'rgb(255, 70, 131)'
      },
      areaStyle: {
        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
          {
            offset: 0,
            color: 'rgb(255, 158, 68)'
          },
          {
            offset: 1,
            color: 'rgb(255, 70, 131)'
          }
        ])
      },
      data: data
    }
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
  </script>

<script type="text/javascript">
var dom1 = document.getElementById('chartContainer1');
var myChart1 = echarts.init(dom1, null, {
    renderer: 'canvas',
    useDirtyRect: false
});

var app = {};

<?php
$sql1 = "SELECT siparis.Cesit, COUNT(siparis.siparisID) as siparissayisi FROM siparis WHERE siparis.iladi = 'İzmir' GROUP BY siparis.Cesit;";
$result1 = mysqli_query($link, $sql1);

$dynamicData1 = array();
while ($row1 = mysqli_fetch_assoc($result1)) {
    $dynamicData1[] = array('name' => $row1['Cesit'], 'value' => $row1['siparissayisi']);
}
?>

var option1;

option1 = {
    title: {
        text: 'İzmir İlinde En Fazla Tercih Edilen Çeşit',
        left: 'center'
    },
    tooltip: {
        trigger: 'item'
    },
    legend: {
        top: '5%',
        left: 'center'
    },
    series: [
        {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 40,
                    fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: <?php echo json_encode($dynamicData1, JSON_NUMERIC_CHECK); ?>
        }
    ]
};

if (option1 && typeof option1 === 'object') {
    myChart1.setOption(option1);
}

window.addEventListener('resize', function () {
    myChart1.resize();
});
</script>

<!-- script2 -->
<script type="text/javascript">
var dom2 = document.getElementById('chartContainer2');
var myChart2 = echarts.init(dom2, null, {
    renderer: 'canvas',
    useDirtyRect: false
});

var app = {};

<?php
$sql2 = "SELECT siparis.Koken, COUNT(siparis.siparisID) as siparissayisi FROM siparis WHERE siparis.iladi = 'Ankara' GROUP BY siparis.Koken;";
$result2 = mysqli_query($link, $sql2);

$dynamicData2 = array();
while ($row2 = mysqli_fetch_assoc($result2)) {
    $dynamicData2[] = array('name' => $row2['Koken'], 'value' => $row2['siparissayisi']);
}
?>

var option2;

option2 = {
    title: {
        text: 'Ankara İlinde En Fazla Tercih Edilen Köken',
        left: 'center'
    },
    tooltip: {
        trigger: 'item'
    },
    legend: {
        top: '5%',
        left: 'center'
    },
    series: [
        {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 40,
                    fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: <?php echo json_encode($dynamicData2, JSON_NUMERIC_CHECK); ?>
        }
    ]
};

if (option2 && typeof option2 === 'object') {
    myChart2.setOption(option2);
}

window.addEventListener('resize', function () {
    myChart2.resize();
});
</script>

<!-- script3 -->
<script type="text/javascript">
var dom3 = document.getElementById('chartContainer3');
var myChart3 = echarts.init(dom3, null, {
    renderer: 'canvas',
    useDirtyRect: false
});

var app = {};

<?php
$sql3 = "SELECT siparis.Kavurma_Derecesi, COUNT(siparis.siparisID) as siparissayisi FROM siparis WHERE siparis.iladi = 'İstanbul' GROUP BY siparis.Kavurma_Derecesi;";
$result3 = mysqli_query($link, $sql3);

$dynamicData3 = array();
while ($row3 = mysqli_fetch_assoc($result3)) {
    $dynamicData3[] = array('name' => $row3['Kavurma_Derecesi'], 'value' => $row3['siparissayisi']);
}
?>

var option3;

option3 = {
    title: {
        text: 'İstanbul İlinde En fazla Tercih Edilen Derece',
        left: 'center'
    },
    tooltip: {
        trigger: 'item'
    },
    legend: {
        top: '5%',
        left: 'center'
    },
    series: [
        {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 40,
                    fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: <?php echo json_encode($dynamicData3, JSON_NUMERIC_CHECK); ?>
        }
    ]
};

if (option3 && typeof option3 === 'object') {
    myChart3.setOption(option3);
}

window.addEventListener('resize', function () {
    myChart3.resize();
});
</script>
<script type="text/javascript">
    var dom4 = document.getElementById('chartContainer4');
    var myChart4 = echarts.init(dom4, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });

    <?php
    $sql4 = "SELECT siparis.Cesit, COUNT(siparis.siparisID) as siparissayisi FROM siparis GROUP BY siparis.Cesit;";
    $result4 = mysqli_query($link, $sql4);

    $dynamicData4 = array();
    while ($row4 = mysqli_fetch_assoc($result4)) {
        $dynamicData4[] = array('name' => $row4['Cesit'], 'value' => $row4['siparissayisi']);
    }
    ?>

    var option4 = {
        title: {
            top: '90%',
            text: 'Tüm Ürünlerin Satış Sayıları',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '-1%',
            left: 'center'
        },
        radar: {
            indicator: <?php echo json_encode($dynamicData4, JSON_NUMERIC_CHECK); ?>
        },
        series: [
            {
                name: 'Access From',
                type: 'radar',
                data: [
                    {
                        value: <?php echo json_encode(array_column($dynamicData4, 'value'), JSON_NUMERIC_CHECK); ?>,
                        name: 'Satış Sayısı'
                    }
                ]
            }
        ]
    };

    if (option4 && typeof option4 === 'object') {
        myChart4.setOption(option4);
    }

    window.addEventListener('resize', function () {
        myChart4.resize();
    });
</script>
<script type="text/javascript">
    var dom5 = document.getElementById('chartContainer5');
    var myChart5 = echarts.init(dom5, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });

    <?php
    $sql5 = "SELECT siparis.Koken, COUNT(siparis.siparisID) as siparissayisi FROM siparis GROUP BY siparis.Koken;";
    $result5 = mysqli_query($link, $sql5);

    $dynamicData5 = array();
    while ($row5 = mysqli_fetch_assoc($result5)) {
        $dynamicData5[] = array('name' => $row5['Koken'], 'value' => $row5['siparissayisi']);
    }
    ?>

    var option5 = {
        title: {
            top: '90%',
            text: 'En Çok Tercih Edilen Köken',
            left: 'center'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: <?php echo json_encode(array_column($dynamicData5, 'name'), JSON_NUMERIC_CHECK); ?>
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            name: 'Çizgiyi Gizle',
            type: 'line',
            stack: 'total',
            areaStyle: {},
            data: <?php echo json_encode(array_column($dynamicData5, 'value'), JSON_NUMERIC_CHECK); ?>
        }]
    };

    if (option5 && typeof option5 === 'object') {
        myChart5.setOption(option5);
    }

    window.addEventListener('resize', function () {
        myChart5.resize();
    });
</script>
<?php
"SELECT siparis.Kavurma_Derecesi, COUNT(siparis.siparisID) as siparissayisi FROM siparis GROUP BY siparis.Koken;";
$sqlBarChart = "SELECT siparis.Kavurma_Derecesi, COUNT(siparis.siparisID) as siparissayisi FROM siparis GROUP BY siparis.Kavurma_Derecesi";
$resultBarChart = mysqli_query($link, $sqlBarChart);

$dynamicDataBarChart = array();
while ($rowBarChart = mysqli_fetch_assoc($resultBarChart)) {
    $dynamicDataBarChart[] = array(
        'name' => $rowBarChart['Kavurma_Derecesi'],
        'value' => $rowBarChart['siparissayisi']
    );
}
?>
<script type="text/javascript">
        var domBarChart = document.getElementById('chartContainer6');
        var myChartBarChart = echarts.init(domBarChart, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        var optionBarChart;

        optionBarChart = {
            title: {
                top: '90%',
                text: 'En Çok Tercih Edilen Kavurma Derecesi',
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            xAxis: {
                type: 'category',
                data: <?php echo json_encode(array_column($dynamicDataBarChart, 'name'), JSON_NUMERIC_CHECK); ?>
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: 'Satış Sayısı',
                    type: 'bar',
                    data: <?php echo json_encode(array_column($dynamicDataBarChart, 'value'), JSON_NUMERIC_CHECK); ?>
                }
            ]
        };

        if (optionBarChart && typeof optionBarChart === 'object') {
            myChartBarChart.setOption(optionBarChart);
        }

        window.addEventListener('resize', function () {
            myChartBarChart.resize();
        });
    </script>
</body>
</html>