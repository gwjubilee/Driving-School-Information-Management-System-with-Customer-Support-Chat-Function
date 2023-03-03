</body>

<!-- scripts -->
<script src="../asset/js/bootstrap.bundle.js"></script>
<!-- responsive header -->
<script src="../asset/js/aos.js"></script>
<script src="../asset/js/jquery-3.6.1.min.js"></script>
<script src="../asset/js/slick.min.js"></script>
<script type="text/javascript">
  AOS.init({
    duration: 1500,
  }
  );
</script>
<script>
  $(function(){
  $('a').each(function() {
    if ($(this).prop('href') == window.location.href) {
      $(this).addClass('current');
    }
  });
  });
</script>


</body>
</html>