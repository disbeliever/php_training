<!doctype html>
<html lang="ru">

  <head>
    <title>Студент: <?= $student->firstName ?> <?= $student->lastName ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="container-fluid">
      <div id="register_form">
        <form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" role="form">
          <div class="form-group">
            <label for="firstName">Имя</label>
            <input name="firstName" type="text" class="form-control" value=""/>
          </div>

          <div class="form-group">
            <label for="lastName">Фамилия</label>
            <input name="lastName" type="text" class="form-control" value=""/>
          </div>
          
          <div class="form-group">
            <label for="group">Группа</label>
            <input name="group" type="text" class="form-control" value=""/>
          </div>
          <button class="btn btn-default" type="submit">Сохранить</button>
        </form>
      </div>
    </div>
  </body>
</html>
