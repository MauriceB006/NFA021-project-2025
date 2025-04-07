<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<div style='color:red'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo "<div style='color:green'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Passenger Reporting System</title>
  <style>
    :root {
      --green-blue-crayola: hsl(244, 59%, 30%);
      --prussian-blue: hsl(202, 72%, 15%);
      --indigo-dye: hsl(202, 64%, 26%);
      --dark-orange: hsl(244, 89%, 17%);
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, var(--green-blue-crayola), var(--prussian-blue), var(--indigo-dye), var(--dark-orange));
      color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      max-width: 800px;
      width: 100%;
      padding: 20px;
      margin-top: 50px;
      background: linear-gradient(135deg, var(--dark-orange), var(--indigo-dye), var(--prussian-blue), var(--green-blue-crayola));
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      animation: fadeIn 1s ease-in-out;
    }

    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      animation: slideIn 0.7s ease-out;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #ffffff;
    }

    input, textarea, select {
      width: 95%;
      padding: 10px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 5px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.1);
      color: #ffffff;
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    input:hover, textarea:hover, select:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    input:focus, textarea:focus, select:focus {
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 8px var(--dark-orange);
      outline: none;
    }

    .radio-group {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .radio-label {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: bold;
      cursor: pointer;
    }

    input[type="radio"] {
      appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid #ffffff;
      border-radius: 50%;
      background: transparent;
      transition: background 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    input[type="radio"]:checked {
      background: linear-gradient(135deg, var(--dark-orange), var(--green-blue-crayola));
      box-shadow: 0 0 5px var(--dark-orange);
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: var(--green-blue-crayola);
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn:hover {
      background-color: var(--dark-orange);
      transform: scale(1.05);
    }

    .btn:active {
      transform: scale(1);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideIn {
      from {
        transform: translateX(-100%);
      }
      to {
        transform: translateX(0);
      }
    }

    option {
      background: rgba(0, 0, 0, 0.85);
      color: #fff;
    }

    option[value="Line B1"]:hover { background: hsl(244, 59%, 30%); }
    option[value="Line B2"]:hover { background: hsl(202, 72%, 15%); }
    option[value="Line B3"]:hover { background: hsl(202, 64%, 26%); }
  </style>
</head>
<body>
  <div class="container">
    <h1>Passenger Reporting System</h1>
    <form action="submit_report.php" method="post">
      <div class="form-group">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required placeholder="Enter your name" />
      </div>
      <div class="form-group">
        <label for="contact">Contact Info:</label>
        <input type="text" id="contact" name="contact" required placeholder="Enter your contact info" />
      </div>
      <div class="form-group">
        <label for="line">Line:</label>
        <select id="line" name="line">
          <option value="Line B1">Line B1</option>
          <option value="Line B2">Line B2</option>
          <option value="Line B3">Line B3</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Date of Incident:</label>
        <input type="date" id="date" name="date" required />
      </div>
      <div class="form-group">
        <label for="time">Time of Incident:</label>
        <input type="time" id="time" name="time" required />
      </div>
      <div class="form-group">
        <label for="description">Incident Description:</label>
        <textarea id="description" name="description" rows="5" required placeholder="Describe what happened..."></textarea>
      </div>
      <div class="form-group">
        <label>Make this report public?</label>
        <div class="radio-group">
          <label class="radio-label">
            <input type="radio" name="public" value="yes" />
            Yes
          </label>
          <label class="radio-label">
            <input type="radio" name="public" value="no" checked />
            No
          </label>
        </div>
      </div>
      <button type="submit" class="btn">Submit Report</button>
    </form>
  </div>
</body>
</html>
