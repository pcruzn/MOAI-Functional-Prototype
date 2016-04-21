<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>


<body>
<?php echo json_encode($encounterTypes); ?>

<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
  <p>
    <input type="submit" name="button" id="button" value="Submit" />
  </p>
</form>
</body>
</html>