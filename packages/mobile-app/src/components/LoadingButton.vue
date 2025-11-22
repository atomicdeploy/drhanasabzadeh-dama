<template>
  <div class="parrentLoad">
    <div id="loader"></div>
  </div>
</template>
<style>
.parrentLoad {
  width: 100% !important;
  display: flex;
  text-align: center;
  justify-content: center;
}
#loader {
 width: 32px;
  margin-top: 4px;
  height: 32px;
  border: 4px solid white;
  border-radius: 50%;
  border-top: 1px solid #00000000;
  -webkit-animation: spin 1s linear infinite;
  animation: spin 1s linear infinite;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}
@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 }
  to { bottom:0px; opacity:1 }
}
@keyframes animatebottom {
  from{ bottom:-100px; opacity:0 }
  to{ bottom:0; opacity:1 }
}
</style>