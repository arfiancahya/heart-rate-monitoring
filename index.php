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
var clientId = "WebSocket";
clientId += new Date().getUTCMilliseconds();;
var topic = "hbrmoni/heart/pulse/beat";
var topic2 = "hbrmoni/heart/pulse/spo";
var pulse = "";
var oksigen = "";

mqttClient = new Paho.MQTT.Client(hostname, port, clientId);
mqttClient.onMessageArrived = MessageArrived;
mqttClient.onConnectionLost = ConnectionLost;
Connect();

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
		
		document.getElementById("pulse").innerHTML=pulse;

	} 

	if (message.destinationName == "hbrmoni/heart/pulse/spo") {
		oksigen = message.payloadString;
		document.getElementById("spo").innerHTML=oksigen;
	} 


	
	// var a=parseInt(message.payloadString);
	// var ht=100-a;
	// document.getElementById("top").style.height=""+ht+"%" ;
	// document.getElementById("top").innerHTML=message.payloadString;
	// document.getElementById("container").style.backgroundColor="yellow";
	// switch(message.payloadString){
	// 	case "ON":
	// 		displayClass = "on";
	// 		break;
	// 	case "OFF":
	// 		displayClass = "off";
	// 		break;
	// 	default:
	// 		displayClass = "unknown";
	// }
	// var topic = message.destinationName.split("/");
	// if (topic.length == 3){
	// 	var ioname = topic[1];
	// 	UpdateElement(ioname, displayClass);
	// }
}
		</script>
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
                      <div class="stats__icon"><span class="fa fa-heartbeat"></span></div>
                      <div class="stats__measure">
                        <div id="pulse" class="stats__values">0.00</div>
                        <div class="stats__unit stats__unit_meters"></div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4"><span class=""></span></a>
                  </div>
                  <div class="dashboard-card__card-piece">
                    <div class="stats__item">
                      <div class="stats__title">SPo2</div>
                      <div class="stats__icon"><span class="wi wi-raindrop"></span></div>
                      <div class="stats__measure">
                        <div id="spo" class="stats__values">0.00</div>
                        <div class="stats__unit stats__unit_meterss"></div>
                      </div>
                    </div>
                    <a href="#" class="dashboard-card__link" tabindex="4"><span class=""></span></a>
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
</body>

</html>