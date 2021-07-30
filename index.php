<script>

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
           /*window.location.href = "android.html";*/
            window.location.href = "pc.html";
      }else{
           window.location.href = "pc.html";
      }


      document.addEventListener("orientationchange", function(event){
    switch(window.orientation)
    {
        case -90: case 90:
            /* Device is in landscape mode */
            break;
        default:
            /* Device is in portrait mode */
    }
});
</script>
