window.onscroll = function(){
  document.getElementById("Background").style.backgroundPosition = "50% "+(-document.documentElement.scrollTop/4)+"px";
}