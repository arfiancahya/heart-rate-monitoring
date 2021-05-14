<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Dashboard";
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
	<script >
var hostname = "broker.mqttdashboard.com";
var port = 8000;
var sessionId = "<?php echo $_SESSION['id_user'] ?>";
var clientId = sessionId;
var topic = "hbrmoni/heart/pulse/beat";
var topic2 = "hbrmoni/heart/pulse/spo";
var pulse = "";
var oksigen = "";

mqttClient = new Paho.MQTT.Client(hostname, port, clientId);
mqttClient.onMessageArrived = MessageArrived;
mqttClient.onConnectionLost = ConnectionLost;
Connect(clientId);

console.log(clientId);

/Initiates a connection to the MQTT broker/
function Connect(){
	mqttClient.connect({
	onSuccess: Connected,
	onFailure: ConnectionFailed,
	keepAliveInterval: 10,
});
}

/*Callback for successful MQTT connection */
function Connected() {
	console.log("Connected to broker");
	mqttClient.subscribe(topic);
    mqttClient.subscribe(topic2);
}

/Callback for failed connection/
function ConnectionFailed(res) {
	console.log("Connect failed:" + res.errorMessage);
}

/Callback for lost connection/
function ConnectionLost(res) {
	if (res.errorCode !== 0) {
		console.log("Connection lost:" + res.errorMessage);
		Connect();
	}
}

/*Callback for incoming message processing */
function MessageArrived(message) {
	console.log(message.destinationName +" : " + message.payloadString);

	if (message.destinationName == "hbrmoni/heart/pulse/beat" ) {
		pulse = message.payloadString;
		document.getElementsByClassName("sensor_value")[0].innerHTML=pulse;

	} 

	if (message.destinationName == "hbrmoni/heart/pulse/spo") {
		oksigen = message.payloadString;
		document.getElementsByClassName("ecg_value")[0].innerHTML=oksigen;
	} 

}
		</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
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
            <h1>Dashboard</h1>
          </div>
          <div class="container">
            <div class="dashboard">
              <div class="dashboard-card wifi">
                <div class="dashboard-card__title"><span class="fa fa-bell-o"></span>MAX30100</div>
                <div class="dashboad-card__content">
                  <div class="dashboard-card__card-piece">
                    <div class="status status_success">
                      <div class="status__icon"><span class="fa fa-check"></span></div>
                      <div class="status__text">Activated</div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="1">Edit<span class="fa fa-angle-right"></span></a>
                  </div>
                </div>
              </div>
              <div class="dashboard-card alarm">
                <div class="dashboard-card__title"><span class="fa fa-bell-o"></span>Indikator Jantung</div>
                <div class="dashboad-card__content">
                  <div class="dashboard-card__card-piece">
                    <div class="status status_danger">
                      <div class="status__icon"><span class="fa fa-times"></span></div>
                      <div class="status__text">Disabled</div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="1">Edit<span class="fa fa-angle-right"></span></a>
                  </div>
                </div>
              </div>
              <div class="dashboard-card light">
                <div class="dashboard-card__title"><span class="fa fa-lightbulb-o"></span>Detak Jantung</div>
                <div class="dashboad-card__content">
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">Pulse</div>
                      <div class="stats__icon"><span class="fa fa-heartbeat color-red"></span></div>
                      <div class="stats__measure">
                        <div id="pulse" class="stats__values">
                        <textarea readonly  name="sensor_value" class="sensor_value" placeholder="0.00" rows="1" cols="1" required></textarea></div>
                        <div class="stats__unit stats__unit_meters"></div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4"><span class=""></span></a>
                  </div>
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">SPo2</div>
                      <div class="stats__icon"><span class="fa fa-tint color-red"></span></div>
                      <div class="stats__measure">
                        <div id="spo" class="stats__values">
                        <textarea readonly name="ecg_value" class="ecg_value" placeholder="0.00" rows="1" cols="1" required></textarea></div>
                        <div class="stats__unit stats__unit_meterss"></div>
                        <input type="hidden" name="id_user" id="id_user"/>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4"><span class=""><input type="submit" class="inp-reload"  value="Reload" onClick="document.location.reload(true)"></span></a>
                  </div>
                </div>
              </div>
              <div class="dashboard-card power">
                <div class="dashboard-card__title"><span class="fa fa-bar-chart"></span>ECG Sensor</div>
                <div class="dashboad-card__content">
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">Water</div>
                      <div class="stats__icon"><span class="wi wi-raindrop"></span></div>
                      <div class="stats__measure">
                        <div class="stats__value">14</div>
                        <div class="stats__unit stats__unit_meter">m</div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4">View in details<span class="fa fa-angle-right"></span></a>
                  </div>
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">Electricity</div>
                      <div class="stats__icon"><span class="fa fa-flash"></span></div>
                      <div class="stats__measure">
                        <div class="stats__value">49</div>
                        <div class="stats__unit stats__unit_power">kw/h</div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4">View in details<span class="fa fa-angle-right"></span></a>
                  </div>
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">Gas</div>
                      <div class="stats__icon"><span class="fa fa-fire"></span></div>
                      <div class="stats__measure">
                        <div class="stats__value">37</div>
                        <div class="stats__unit stats__unit_meter">m</div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4">View in details<span class="fa fa-angle-right"></span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php include 'part/footer.php'; ?>
    </div>
  </div>

  <?php include "part/all-js.php"; ?>

  <script src="./assets/js/loading.js"></script>
  <script>  
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
           }, 60000);  
 });  
 </script>
 <script type="text/javascript">
function reloadpage()
{
location.reload()
}
</script>
</script>
</body>

</html>