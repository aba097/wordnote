var target = 'table';
divobj = document.getElementsByTagName('div');
tartgetobj = new RegExp(target);
for(i = 0; i < divobj.length; i++){
  if(divobj[i].id.match(tartgetobj)){
    divobj[i].style.display = "none";
  }
}

function tableswitch(id){
  if(document.getElementById('table' + id).style.display == "none"){
    document.getElementById('table' + id).style.display = "block";
  }else{
    document.getElementById('table' + id).style.display = "none";
  }

}
