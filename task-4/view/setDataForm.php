<?php

namespace view;

?>

<div class="w-50 m-auto border rounded">
    <div class="position-absolute text-primary bg-white ml-3 mt-n3 pt-1 px-2">Add your phone number</div>
    <div class="font-weight-bold mt-5 ml-5">Option 1. Add your phone number</div>

    <form class="p-5" action="/set" method="post">
        <div class="form-group">
            <label for="phoneInput">Enter your PHONE:</label>
            <input type="tel" class="form-control" id="phoneInput" name="phone" value="<?= $_POST['phone'] ?>" required>
        </div>
        <div class="form-group">
            <label for="emailInput">Enter your e-mail *:</label>
            <input type="email" class="form-control" for="emailInput" name="email" value="<?= $_POST['email'] ?>" required>
        </div>
        <div class="text-danger mb-3"><?= $error ?></div>
        <div>
            * Your will be able to retrieve your phone number later on using your e-mail.
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
</div>