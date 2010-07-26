var mt_current=0
var mt_clipwidth=0

function mt_changeticker(){
mt_crosstick.style.clip="rect(0px 0px auto 0px)"
mt_crosstick.innerHTML=mt_contents[mt_current]
mt_highlight()
}

function mt_highlight(){
var mt_msgwidth=mt_crosstick.offsetWidth
if (mt_clipwidth<mt_msgwidth){
mt_clipwidth+=mt_speed
mt_crosstick.style.clip="rect(0px "+mt_clipwidth+"px auto 0px)"
mt_begin=setTimeout("mt_highlight()",20)
}
else{
mt_clipwidth=0
clearTimeout(mt_begin)
if (mt_current==mt_contents.length-1) mt_current=0
else mt_current++
setTimeout("mt_changeticker()",mt_delay)
}
}

function mt_start(){
mt_crosstick=document.getElementById? document.getElementById("mt_spancontant") : document.all.mt_spancontant
mt_crosstickParent=mt_crosstick.parentNode? mt_crosstick.parentNode : mt_crosstick.parentElement
if (parseInt(mt_crosstick.offsetHeight)>0)
mt_crosstickParent.style.height=mt_crosstick.offsetHeight+'px'
else
setTimeout("mt_crosstickParent.style.height=mt_crosstick.offsetHeight+'px'",100) //delay for Mozilla's sake
mt_changeticker()
}