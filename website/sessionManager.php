<?php
session_start();

function isUserLogged()
{
	return isset($_SESSION['idUser']) && isset($_SESSION['username']) && isset($_SESSION['email']);
}

function getSessionUserId()
{
	return $_SESSION['idUser'];
}

function getSessionUsername()
{
	return $_SESSION['username'];
}

function getSessionEmail()
{
	return $_SESSION['email'];
}

function setSessionBook($id_ebook)
{
	$_SESSION['buyingItem'] = $id_ebook;
}

function getSessionBook()
{
	return $_SESSION['buyingItem'];
}

function checkBook()
{
	return isset($_SESSION['buyingItem']);
}

function resetBook()
{
	unset($_SESSION['buyingItem']);
}

function logout()
{
	session_unset();
	header('location: index.php');
}

function setErrorMessage($message)
{
	$_SESSION["errorMessage"] = $message;
}

function isThereAnyErrorMessage()
{
	return isset($_SESSION["errorMessage"]) && strlen($_SESSION["errorMessage"]) > 0;
}

function readErrorMessage($readOnce = true)
{
	if (isset($_SESSION["errorMessage"])) {
		$tmp = $_SESSION["errorMessage"];
		if ($readOnce) {
			unset($_SESSION["errorMessage"]);
		}
		return $tmp;
	}
	return "";
}

function printErrorSessionMessage()
{
	if (isThereAnyErrorMessage()) {
?>
		<div class="alert alert-danger mt-2">
			<strong>Error!</strong> <?php echo readErrorMessage() ?>
		</div>
	<?php
	}
}

function setSuccessMessage($message)
{
	$_SESSION["successMessage"] = $message;
}

function isThereAnySuccessMessage()
{
	return isset($_SESSION["successMessage"]) && strlen($_SESSION["successMessage"]) > 0;
}

function readSuccessMessage($readOnce = true)
{
	if (isset($_SESSION["successMessage"])) {
		$tmp = $_SESSION["successMessage"];
		if ($readOnce) {
			unset($_SESSION["successMessage"]);
		}
		return $tmp;
	}
	return "";
}

function printSuccessSessionMessage()
{
	if (isThereAnySuccessMessage()) {
	?>
		<div class="alert alert-success mt-2">
			<strong>Success!</strong> <?php echo readSuccessMessage() ?>
		</div>
<?php
	}
}

?>