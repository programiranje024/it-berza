async function getTime() {
  const data = await fetch("/time.php");
  const { time } = await data.json();
  document.getElementById("time").innerHTML = time;
}

setInterval(getTime, 1000);
