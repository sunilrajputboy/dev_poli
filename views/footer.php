<footer class="footer">
   <div class="container-fluid">
      <p class="copyright pull-right">
            Release 1.0.0 &copy;  - <a href="<?php echo BASE_COPYRIGHT;?>" target="_blank"><b><?php echo BASE_COPYRIGHT;?></b></a></p>
   </div>
</footer>
</div>
</div>
</div>
</div>
</div>
</body>
<script src="<?php echo BASE_URL; ?>public/assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/jquery.dataTables.min.js"></script>	
<script src="<?php echo BASE_URL; ?>public/assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.rows.js"></script>
<script>$(document).ready(function(){ $('[data-toggle="tooltip"]').tooltip(); });</script>
<?php  if (isset($this->js)) { foreach ($this->js as $js) { echo '<script type="text/javascript" src="'.BASE_URL.'views/'.$js.'"></script>'; } }?>
<script src="<?php echo BASE_URL; ?>public/assets/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/navigation.js"></script>
</html>