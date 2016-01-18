<!doctype html>
<html lang="ru">

  <head>
    <title><?=htmlspecialchars($title)?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="container-fluid">
      <nav>
        <a href="/index.php">Список абитуриентов</a>
      </nav>
      <?php if(isset($succString) && $succString != ""): ?>
        <div class="alert alert-success"><?=$succString?></div>
      <?php endif; ?>
      <div id="register_form">
        <form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" role="form">

          <?php if ($id > 0): ?>
            <input name="id" type="hidden" value="<?=$id?>"/>
          <?php endif ?>

          <div class="form-group <?=isset($errors['firstName']) ? "has-error" : "" ?>">
            <label for="firstName" class="control-label">Имя</label>
            <?php if(isset($errors['firstName'])): ?>
              <label class="control-label"><?=$errors['firstName']?></label>
            <?php endif; ?>
            <input class="form-control" name="firstName" type="text" maxlength="200" required value="<?=htmlspecialchars($student->firstName)?>"/>
          </div>

          <div class="form-group <?=isset($errors['lastName']) ? "has-error" : "" ?>">
            <label for="lastName">Фамилия</label>
            <input class="form-control" name="lastName" type="text" maxlength="200" required value="<?=htmlspecialchars($student->lastName)?>"/>
            <?php if(isset($errors['lastName'])): ?>
              <label class="control-label"><?=$errors['lastName']?></label>
            <?php endif; ?>
          </div>
          
          <div class="form-group <?=isset($errors['group']) ? "has-error" : "" ?>">
            <label for="group">Группа</label>
            <input class="form-control" name="group" type="text" maxlength="5" required value="<?=htmlspecialchars($student->group)?>"/>
            <?php if(isset($errors['group'])): ?>
              <label class="control-label"><?=$errors['group']?></label>
            <?php endif; ?>
          </div>

          <div class="form-group <?=isset($errors['mark']) ? "has-error" : "" ?>">
            <label for="mark">Баллы</label>
            <input class="form-control" name="mark" type="number" min="0" max="300" required value="<?=$student->mark?>"/>
            <?php if(isset($errors['mark'])): ?>
              <label class="control-label"><?=$errors['mark']?></label>
            <?php endif; ?>
          </div>

          <div class="form-group <?=isset($errors['gender']) ? "has-error" : "" ?>">
            <label for="gender">Пол</label>
            <div class="radio">
              <label><input name="gender" type="radio" value="male" <?=$student->gender == Student::GENDER_MALE ? "checked" : ""?>/>М</label>
            </div>
            <div class="radio">
              <label><input name="gender" type="radio" value="female" <?=$student->gender == Student::GENDER_FEMALE ? "checked" : ""?>/>Ж</label>
            </div>
            <?php if(isset($errors['gender'])): ?>
              <label class="control-label"><?=$errors['gender']?></label>
            <?php endif; ?>
          </div>

          <div class="form-group <?=isset($errors['birthyear']) ? "has-error" : "" ?>">
            <label for="birthyear">Год рождения</label>
            <input class="form-control" name="birthyear" type="number" min="1900" max="2000" required value="<?=$student->birthyear?>"/>
            <?php if(isset($errors['birthyear'])): ?>
              <label class="control-label"><?=$errors['birthyear']?></label>
            <?php endif; ?>
          </div>

          <div class="form-group <?=isset($errors['email']) ? "has-error" : "" ?>">
            <label for="email">E-mail</label>
            <input class="form-control" name="email" type="email" maxlength="254" required value="<?=htmlspecialchars($student->email)?>"/>
            <?php if(isset($errors['email'])): ?>
              <label class="control-label"><?=$errors['email']?></label>
            <?php endif; ?>
          </div>

          <button class="btn btn-default" type="submit" value="1"><?=$saveButtonText?></button>
        </form>
      </div>
    </div>
  </body>
</html>
