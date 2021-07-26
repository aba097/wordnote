function inputformchange(){
  var form1 = document.getElementById('form1');
  var form2 = document.getElementById('form2');
  var form3 = document.getElementById('form3');

  radio = document.getElementsByName('inputform')
  if(radio[0].checked){
    form1.style.display = "block"
    form2.style.display = "none"
    form3.style.display = "none"
  }else if(radio[1].checked){
    form1.style.display = "none"
    form2.style.display = "block"
    form3.style.display = "none"
  }else if(radio[2].checked){
    form1.style.display = "none"
    form2.style.display = "none"
    form3.style.display = "block"
  }
}

window.addEventListener('load', inputformchange());
