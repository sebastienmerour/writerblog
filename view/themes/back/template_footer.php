<footer class="shadow container-fluid">
  <div class="row text-center">
    <div class="col-12 bg-danger p-3">
       <h6 class="lead font-weight-bold text-white"><?= WEBSITE_NAME; ?>&nbsp;|&nbsp;<span class="font-weight-lighter"><?= WEBSITE_SUBTITLE; ?></span>&nbsp;|&nbsp;&copy; <?= COPYRIGHT_YEAR ;?></h6>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Custom JavaScript for this theme -->
<script src="<?= BASE_URL; ?>public/js/scroll.js"></script>
<script src="<?= BASE_URL; ?>public/js/password_policy.js"></script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>feather.replace()</script>
<script>
    $('#uploadimage').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        fileName = fileName.substring(fileName.lastIndexOf("\\") + 1, fileName.length);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
</body>
</html>
