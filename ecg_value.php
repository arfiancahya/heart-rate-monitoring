<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $page = "Ecg";
    session_start();
    include 'auth/connect.php';
    include "part/head.php";
    include 'part_func/tgl_ind.php';
    include "part_func/umur.php";

    $sessionid = $_SESSION['id_user'];

    if (!isset($sessionid)) {
        header('location:auth');
    }
    $nama = mysqli_query($conn, "SELECT * FROM user WHERE id=$sessionid");
    $output = mysqli_fetch_array($nama);

    $tampilPeg    = mysqli_query($conn, "SELECT * FROM history WHERE id_user=$sessionid");
    $peg    = mysqli_fetch_array($tampilPeg);

    ?>
    <style>
        #link-no {
            text-decoration: none;
        }
    </style>

    <link rel="stylesheet" href="./assets/css/dahs.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js"></script>
    <script type="text/javascript">
        /*
by @bordignon on twitter
Feb 2014
Simple example of plotting live mqtt/websockets data using highcharts.
public broker and topic you can use for testing.
	var MQTTbroker = 'broker.mqttdashboard.com';
	var MQTTport = 8000;
	var MQTTsubTopic = 'dcsquare/cubes/#'; //works with wildcard # and + topics dynamically now
*/

        //settings BEGIN
        var MQTTbroker = 'broker.mqttdashboard.com';
        var MQTTport = 8000;
        var MQTTsubTopic = 'hbrmoni/heart/pulse/#'; //works with wildcard # and + topics dynamically now
        //settings END

        var chart; // global variuable for chart
        var dataTopics = new Array();

        //mqtt broker 
        var client = new Paho.MQTT.Client(MQTTbroker, MQTTport,
            "myclientid_" + parseInt(Math.random() * 100, 10));
        client.onMessageArrived = onMessageArrived;
        client.onConnectionLost = onConnectionLost;
        //connect to broker is at the bottom of the init() function !!!!


        //mqtt connecton options including the mqtt broker subscriptions
        var options = {
            timeout: 3,
            onSuccess: function() {
                console.log("mqtt connected");
                // Connection succeeded; subscribe to our topics
                client.subscribe(MQTTsubTopic, {
                    qos: 1
                });
            },
            onFailure: function(message) {
                console.log("Connection failed, ERROR: " + message.errorMessage);
                //window.setTimeout(location.reload(),20000); //wait 20seconds before trying to connect again.
            }
        };

        //can be used to reconnect on connection lost
        function onConnectionLost(responseObject) {
            console.log("connection lost: " + responseObject.errorMessage);
            //window.setTimeout(location.reload(),20000); //wait 20seconds before trying to connect again.
        };

        //what is done when a message arrives from the broker
        function onMessageArrived(message) {
            // console.log(message.destinationName, '', message.payloadString);

            //check if it is a new topic, if not add it to the array
            if (dataTopics.indexOf(message.destinationName) < 0) {

                dataTopics.push(message.destinationName); //add new topic to array
                var y = dataTopics.indexOf(message.destinationName); //get the index no

                //create new data series for the chart
                var newseries = {
                    id: y,
                    name: message.destinationName,
                    data: []
                };

                chart.addSeries(newseries); //add the series

            };

            var y = dataTopics.indexOf(message.destinationName); //get the index no of the topic from the array
            var myEpoch = new Date().getTime(); //get current epoch time
            var thenum = message.payloadString.replace(/^\D+/g, ''); //remove any text spaces from the message
            var plotMqtt = [myEpoch, Number(thenum)]; //create the array
            if (isNumber(thenum)) { //check if it is a real number and not text
                console.log('is a propper number, will send to chart.')
                plot(plotMqtt, y); //send it to the plot function
            };
        };

        //check if a real number	
        function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        };

        //function that is called once the document has loaded
        function init() {

            //i find i have to set this to false if i have trouble with timezones.
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });

            // Connect to MQTT broker
            client.connect(options);

        };


        //this adds the plots to the chart	
        function plot(point, chartno) {
            console.log(point);

            var series = chart.series[0],
                shift = series.data.length > 20; // shift if the series is 
            // longer than 20
            // add the point
            chart.series[chartno].addPoint(point, true, shift);

        };

        //settings for the chart
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js" type="text/javascript"></script>
    <script src="http://code.highcharts.com/stock/highstock.js"></script>
    <script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
</head>

<body onload="init();">
    <div class="loading">
        <div class="load">
            <div class="heart-rate">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="150px" height="73px" viewBox="0 0 150 73" enable-background="new 0 0 150 73" xml:space="preserve">
                    <polyline fill="none" stroke="#009B9E" stroke-width="3" stroke-miterlimit="10" points="0,45.486 38.514,45.486 44.595,33.324 50.676,45.486 57.771,45.486 62.838,55.622 71.959,9 80.067,63.729 84.122,45.486 97.297,45.486 103.379,40.419 110.473,45.486 150,45.486" />
                </svg>
                <div class="fade-in"></div>
                <div class="fade-out"></div>
            </div>
            <h1>Loading to my website.... </h1>
        </div>
    </div>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <?php
            include 'part/navbar.php';
            include 'part/sidebar.php';
            ?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Ecg Value</h1>
                    </div>
                    <div class="container">
                    <div id="graph" style="height: 500px; min-width: 500px"></div><!-- this the placeholder for the chart-->
                    </div>
                        
            </div>
            </section>
        </div>
        <?php include 'part/footer.php'; ?>
    </div>
    </div>

    <?php include "part/all-js.php"; ?>



    <script src="./assets/js/loading.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'graph',
                    defaultSeriesType: 'spline'
                },
                title: {
                    text: 'Plotting Live websockets data from a MQTT topic'
                },
                subtitle: {
                    text: 'broker: ' + MQTTbroker + ' | port: ' + MQTTport + ' | topic : ' + MQTTsubTopic
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 5000,
                    maxZoom: 20 * 1000
                },
                yAxis: {
                    minPadding: 0.2,
                    maxPadding: 0.2,
                    title: {
                        text: 'Value',
                        margin: 80
                    }
                },
                series: []
            });
        });
        </script>
    <!-- <script>  
 $(document).ready(function(){  
      function autoSave()  
      {  
           var sensor_value = $('.sensor_value').val();  
           var ecg_value = $('.ecg_value').val();  
           var id_user = "<?php echo $_SESSION['id_user'] ?>";  
           if(sensor_value != '' && ecg_value != '')  
           {  
                $.ajax({  
                     url:"save_db.php",  
                     method:"POST",  
                     data:{sensorValue:sensor_value, sensorEcg:ecg_value, clientID:id_user},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                          if(data != '')  
                          {  
                               $('#id_user').val(data);  
                          }  
                     }  
                });  
           }            
      }  
      setInterval(function(){   
           autoSave();   
           }, 1000);  
 });  
 </script> -->
</body>

</html>