document.getElementById('back').style.display = "none";

function change(){
  if(document.getElementById('front').style.display == "none"){
    document.getElementById('front').style.display = "block";
    document.getElementById('back').style.display = "none";
  }else{
    document.getElementById('front').style.display = "none";
    document.getElementById('back').style.display = "block";
  }

}
