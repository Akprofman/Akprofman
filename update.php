<?php
    include './templates/header.php';
    include 'config/db_connect.php';
    if (isset($_POST['update'])) {

        if (empty($_POST['email'])) {
            $errors['email'] = "An email is required <br/>";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email must be valid email address <br/>";
            }
        }
        if (empty($_POST['title'])) {
            $errors['title'] = "A title is required <br/>";
        } else {
            if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
                $errors['title'] = "Title must be letters and spaces only";
            }
        }
        if (empty($_POST['ingredients'])) {
            $errors['ing'] = "At least one Ingredient is required <br/>";
        } else {
            if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $errors['ingredients'] = "Ingredients must be comma seperated list";
            }
        }
    }
        if (array_filter($errors)) {
            //do nothing since there is something handling it already.
        } else {
            //just like htmlspecialchar .. we have something to prepare us for sql injection
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredeients']);


        $id_update = mysqli_real_escape_string($conn, $_POST['id_update']);
        $sql = "UPDATE pizzas SET email=$email, title=$title, ingredients=$ingredients WHERE id = $id_update";
        if (mysqli_query($conn, $sql)) {
            //successful
            header('location: index.php');
        } {
            //failure
            echo 'query error:' . mysqli_error($conn);
        }
    }
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql2 = "SELECT title,ingredients,email FROM pizzas WHERE id = $id";
        $result = mysqli_query($conn, $sql2);
        $pizzas = mysqli_fetch_assoc($result);
        $title=$pizzas["title"];
        $ingredients=$pizzas["ingredients"];
        $email=$pizzas["email"];
        mysqli_free_result($result);
        mysqli_close($conn);
    }

?>
<section class="container green-text">
    <h4 class="center">Update Pizza</h4>
    <form class="white" action="update.php" method="POST">
        <label for="email">Your Email:</label>
        <!-- Always use server side and client side validation after using required -->
        <input type="text" name="email" value="<?php echo $email ?>"required>
        <div class="red-text">
            <!-- display errors right after the input field -->
        </div>
        <label for="title">Pizza Title:</label>
        <input type="text" name="title" value="<?php echo $title ?>"required>
        <div class="red-text">
        </div>
        <label for="">Ingredients (comma Separated):</label>
        <input type="text" name="ingredients" value="<?php echo $ingredients ?>"required>
        <div class="red-text">
        
        </div>
        <div class="center">
            <button type="submit" class="btn brand z-depth-0" name="update" value="update">Update</button>
            
        </div>
    </form>
</section>

<?php
include './templates/footer.php';
?>