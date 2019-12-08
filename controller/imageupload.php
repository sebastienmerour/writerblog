<?php
if (isset($_POST["modify"])) {
    $errors   = array();
    $messages = array();
    $item_id  = $this->request->getParameter("id");
    $title    = $this->request->getParameter("title");
    $content  = $this->request->getParameter("content");
    $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    $extensions_authorized = array(
        "gif",
        "png",
        "jpg",
        "jpeg"
    );
    $extension_upload = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $time                  = date("Y-m-d-H-i-s") . "-";
    $newtitle              = str_replace(' ', '-', strtolower($title));
    $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
    $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
    $itemimagename         = "{$time}$newtitle.{$extension_upload}";
    $destination           = ROOT_PATH . 'public/images/item_images';

    if (! file_exists($_FILES["image"]["tmp_name"])) {
      $errors['errors'] = 'Merci de sélectionner un fichier';
      if (!empty($messages)) {
          $_SESSION['errors'] = $errors;
          header('Location: ../readitem/' . $item_id);
          exit;
        }
      }
    else if (! in_array($extension_upload, $extensions_authorized)) {
      $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
      if (!empty($messages)) {
          $_SESSION['errors'] = $errors;
          header('Location: ../readitem/' . $item_id);
          exit;
        }
    }
    else if (($_FILES["image"]["size"] > 1000000)) {
      $errors['errors'] = 'Le fichier est trop lourd.';
      if (!empty($messages)) {
          $_SESSION['errors'] = $errors;
          header('Location: ../readitem/' . $item_id);
          exit;
        }
    }
    else if ($width > "300" || $height > "200") {
      $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
      if (!empty($messages)) {
          $_SESSION['errors'] = $errors;
          header('Location: ../readitem/' . $item_id);
          exit;
        }
      else {
        move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
        $this->item->changeItemImage($title, $itemimagename, $content, $item_id);
        }
    }
}
?>
