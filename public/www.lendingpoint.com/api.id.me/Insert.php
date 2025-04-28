<!DOCTYPE html>
<head>
<title>Insert data to PostgreSQL with php - creating a simple web application</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
li {
list-style: none;
}
</style>
</head>
<body>
<h2>Enter data into book table</h2>
<ul>
<form name="insert" action="insert.php" method="POST" >
<li>Book ID:</li><li><input type="text" name="bookid" /></li>
<li>Book Name:</li><li><input type="text" name="book_name" /></li>
<li>Price (USD):</li><li><input type="text" name="price" /></li>
<li>Date of publication:</li><li><input type="text" name="dop" /></li>
<li><input type="submit" /></li>
</form>
</ul>
</body>
</html>

<?php
$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=myadmin123");
$query = "INSERT INTO book VALUES ('$_POST[bookid]','$_POST[book_name]')";
$result = pg_query($query); 
?>


You see as the code be... weti you think say abi how you think say e easy to just find mistake abi error in as code many like that??

No wahala, I just say make I show you, no problem.
