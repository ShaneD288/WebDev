<?php include 'header.php'; 
session_start();
include 'config.php';

// only allow logged in users to view pages 
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// update prescription
$edit_id = null;
$edit_data = null;

// check for id 
if(isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
	// get data from database 
    $result = mysqli_query($conn, "SELECT * FROM prescriptions WHERE id = '$edit_id'");
    if(mysqli_num_rows($result) > 0) {
        $edit_data = mysqli_fetch_assoc($result);
    }
}
// add prescription
if(isset($_POST['submit'])) {
	// form
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $dob = $_POST['dob'];
    $medicine = $_POST['medicine'];
    $length = $_POST['length'];
    $prescription_id = $_POST['prescription_id'] ?? null;

    if($prescription_id) {
        // Update existing prescription
        mysqli_query($conn, "UPDATE prescriptions SET 
        first_name='$fname', last_name='$lname', dob='$dob', medicine='$medicine', length='$length' 
        WHERE id='$prescription_id'");
    } else {
        // Insert new prescription
        mysqli_query($conn, "INSERT INTO prescriptions 
        (first_name, last_name, dob, medicine, length) 
        VALUES ('$fname','$lname','$dob','$medicine','$length')");
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dillons Pharmacy | Prescription Renewal</title>
	<style>
		:root {
			--bg: #f3f8f4;
			--primary: #1f6f4a;
			--primary-dark: #154e34;
			--accent: #f2b84b;
			--text: #1d2a22;
			--white: #ffffff;
			--shadow: 0 8px 24px rgba(24, 53, 39, 0.15);
		}

		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			background: radial-gradient(circle at top left, #e9f4ec 0%, var(--bg) 60%);
			color: var(--text);
			min-height: 100vh;
		}

		header {
			position: sticky;
			top: 0;
			z-index: 100;
			background: var(--white);
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
			padding: 14px 18px;
		}

		.top-bar {
			max-width: 1100px;
			margin: 0 auto;
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			flex-wrap: wrap;
		}

        .logo {
			font-size: 22px;
			font-weight: 700;
			color: var(--primary);
			text-decoration: none;
		}


		main {
			max-width: 1100px;
			margin: 40px auto;
			padding: 0 20px;
		}

		.hero {
			text-align: center;
			margin-bottom: 40px;
		}

		.hero h1 {
			font-size: 42px;
			color: var(--primary);
			margin: 0 0 15px;
		}

		.hero p {
			font-size: 16px;
			color: var(--text);
			margin: 0;
		}

		.box {
			background: var(--white);
			padding: 30px;
			border-radius: 12px;
			box-shadow: var(--shadow);
			margin-bottom: 30px;
		}

		.box h2 {
			color: var(--primary);
			margin-top: 0;
		}

		.renewal-form {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
		}

		.field {
			display: flex;
			flex-direction: column;
		}

		.field.full {
			grid-column: 1 / -1;
		}

		.field label {
			font-weight: 600;
			color: var(--text);
			margin-bottom: 8px;
		}

		.field input {
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 14px;
		}

		.field input:focus {
			outline: none;
			border-color: var(--primary);
			box-shadow: 0 0 0 3px rgba(31, 111, 74, 0.1);
		}

		.btn {
			background: var(--primary);
			color: var(--white);
			padding: 12px 30px;
			border: none;
			border-radius: 6px;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			transition: background 0.3s;
		}

		.btn:hover {
			background: var(--primary-dark);
		}

		.btn-secondary {
			background: #999;
			margin-top: 10px;
		}

		.btn-secondary:hover {
			background: #777;
		}
	</style>
</head>
<body>

<main>
    <section class="hero">

        <h1>Prescription Renewal</h1>
        <p>Fill out the form below to request a prescription renewal.</p>

        <!--  form -->
        <div class="box">
            <h2><?php echo $edit_data ? 'Edit Prescription' : 'Renewal Request Form'; ?></h2>

            <form method="POST" class="renewal-form">
                <?php if($edit_data): ?>
                    <input type="hidden" name="prescription_id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>

                <div class="field">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?php echo $edit_data['first_name'] ?? ''; ?>" required>
                </div>

                <div class="field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?php echo $edit_data['last_name'] ?? ''; ?>" required>
                </div>

                <div class="field">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" value="<?php echo $edit_data['dob'] ?? ''; ?>" required>
                </div>

                <div class="field full">
                    <label>Medicine</label>
                    <input type="text" name="medicine" value="<?php echo $edit_data['medicine'] ?? ''; ?>" required>
                </div>

                <div class="field">
                    <label>Prescription Length</label>
                    <input type="text" name="length" placeholder="e.g. 3 Months" value="<?php echo $edit_data['length'] ?? ''; ?>" required>
                </div>

                <div class="field full">
                    <button class="btn" name="submit"><?php echo $edit_data ? 'Update Prescription' : 'Submit Request'; ?></button>
                    <?php if($edit_data): ?>
                        <a href="prescription.php" class="btn btn-secondary" style="display:inline-block; text-align:center; text-decoration:none; margin-left:10px;">Cancel</a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <!-- display data -->
        <div class="box">
            <h2>Saved Prescriptions</h2>

            <?php
			// get prescription data
            $result = mysqli_query($conn, "SELECT * FROM prescriptions");
			// error check
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
					// display details
                    echo "<div style='margin-bottom:10px; padding:10px; border:1px solid #ccc; border-radius:8px;'>
                        <strong>{$row['first_name']} {$row['last_name']}</strong><br>
                        DOB: {$row['dob']}<br>
                        Medicine: {$row['medicine']}<br>
                        Length: {$row['length']}<br>
                        <a href='prescription.php?edit={$row['id']}' style='color:var(--primary); margin-right:15px; text-decoration:none; font-weight:500;'>Edit</a>
                        <a href='delete.php?id={$row['id']}' style='color:red; text-decoration:none; font-weight:500;'>Delete</a>
                    </div>";
                }
            } else {
                echo "<p>No prescriptions yet.</p>";
            }
            ?>

        </div>

    </section>
</main>

</body>
</html>
