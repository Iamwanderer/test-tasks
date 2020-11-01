<?php

namespace view;

?>

<div class="w-50 m-auto border rounded">
    <div class="position-absolute text-primary bg-white ml-3 mt-n3 pt-1 px-2">Retrieve your phone number</div>
    <div class="font-weight-bold mt-5 ml-5">Option 2. Retrieve your phone number</div>

    <form class="p-5" method="post">
        <div class="form-group">
            <label for="emailInput">Enter your e-mail *:</label>
            <input type="email" class="form-control" id="emailInput" name="email" value="<?= $_POST['email'] ?>" required>
        </div>
        <div class="text-danger mb-3"><?= $error ?></div>
        <div>
            * The phone will be e-mailed to your.
        </div>
        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
</div>


</form>
</div>