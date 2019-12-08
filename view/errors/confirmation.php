<?php if (!empty($_SESSION['messages']['confirmation']))
          {?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= $_SESSION['messages']['confirmation'];
              ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php
          }
unset($_SESSION['messages']);
