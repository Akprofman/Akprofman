<?php
//check GET request id parameter
include 'config/db_connect.php';
if (isset($_POST['delete'])) {

    $id_delete = mysqli_real_escape_string($conn, $_POST['id_delete']);
    $sql = "DELETE FROM pizzas WHERE id = $id_delete";
    if (mysqli_query($conn, $sql)) {
        //successful
        header('location: index.php');
    } {
        //failure
        echo 'query error:' . mysqli_error($conn);
    }
}
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    //make sql
    $sql = "SELECT * FROM pizzas where id = $id";
    //get the query result
    $result = mysqli_query($conn, $sql);
    //fetch only one result with mysqli_fetch_assoc and converts to associative array
    $pizza = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);

    //
}


include 'templates/header.php';
?>

<div class="container center">
    <?php if ($pizza) : ?>
        <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
        <p>Created by:<?php echo htmlspecialchars($pizza['email']); ?></p>
        <p> <?php echo date($pizza['date_created']); ?></p>
        <h5>Ingredients:</h5>
        <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>
        <!--DELETE FORM -->
        <form action="details.php" method="POST">
            <input type="hidden" name="id_delete" value="<?php echo $pizza['id']; ?>">
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>
    <?php else : ?>
        <h5>No such pizza In our database</h5>
    <?php endif; ?>
    <?php?>
      <form action="update.php" method="POST">
            <input type="hidden" name="id_update" value="<?php echo $pizza['id']; ?>">
            <input type="submit" class="btn brand z-depth-0" name="update" value="Update" href="update.php?id=<?php echo $pizza['id']; ?>"></button>
      </form>  
</div>
<?php
include 'templates/footer.php';
?>