<?php
session_start();
require 'dB.php';

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

// Logout handler
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Handle filter
$filter = trim($_GET['filter'] ?? '');

// Query candidates and vote counts
$sql = "
    SELECT c.id, c.name, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    WHERE c.name LIKE ?
    GROUP BY c.id, c.name
    ORDER BY vote_count DESC
";
$stmt = $conn->prepare($sql);
$searchParam = "%$filter%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$candidates = [];
while ($row = $result->fetch_assoc()) {
    $candidates[] = $row;
}

// Total votes cast
$sqlTotal = "SELECT COUNT(*) AS total_votes FROM votes";
$totalResult = $conn->query($sqlTotal);
$totalVotes = $totalResult->fetch_assoc()['total_votes'];

// CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="election_results.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Candidate Name', 'Votes']);

    foreach ($candidates as $cand) {
        fputcsv($output, [str_replace(["\n", "\r", "\t"], '', $cand['name']), $cand['vote_count']]);
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Election Results - University E-Voting</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background: url('https://images.squarespace-cdn.com/content/v1/61c4da8eb1b30a201b9669f2/e2e0e62f-0064-4f86-b9d8-5a55cb7110ca/Korembi-January-2024.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }
    .overlay {
      background-color: rgba(0,0,0,0.65);
      min-height: 100vh;
      padding: 40px 20px;
      box-sizing: border-box;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
    }
    .btn-back, .btn-logout {
      padding: 12px 22px;
      font-weight: 700;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-back {
      background-color: #2980b9;
    }
    .btn-back:hover {
      background-color: #1f5d91;
    }
    .btn-logout {
      background-color: #e74c3c;
    }
    .btn-logout:hover {
      background-color: #c0392b;
    }
    main {
      max-width: 900px;
      margin: 0 auto;
      background: rgba(255,255,255,0.1);
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
    }
    .total-votes {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 10px;
      text-align: center;
    }
    .download-btn {
      display: block;
      margin: 10px auto 30px;
      background-color: #27ae60;
      color: white;
      padding: 12px 24px;
      font-weight: bold;
      border-radius: 6px;
      text-align: center;
      width: fit-content;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .download-btn:hover {
      background-color: #1e8449;
    }
    form.filter-form {
      margin-bottom: 20px;
      text-align: center;
    }
    form.filter-form input[type="text"] {
      padding: 10px 14px;
      width: 260px;
      font-size: 16px;
      border-radius: 6px;
      border: none;
      outline: none;
      box-shadow: 0 0 6px rgba(0,0,0,0.2);
    }
    form.filter-form button {
      padding: 10px 20px;
      margin-left: 10px;
      font-weight: 700;
      border-radius: 6px;
      border: none;
      background-color: #3498db;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    form.filter-form button:hover {
      background-color: #2980b9;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: rgba(255,255,255,0.9);
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 15px 20px;
      text-align: left;
      font-weight: 600;
      color: #333;
    }
    th {
      background-color: #2980b9;
      color: white;
    }
    tbody tr:nth-child(even) {
      background-color: #ecf0f1;
    }
    tbody tr:hover {
      background-color: #d1d8e0;
    }
    @media(max-width: 600px) {
      main {
        padding: 20px;
      }
      form.filter-form input[type="text"] {
        width: 70%;
      }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <header>
      <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
      <a href="?action=logout" class="btn-logout">Logout</a>
    </header>

    <main>
      <h1>Election Results</h1>

      <div class="total-votes">Total Votes Cast: <?= number_format($totalVotes) ?></div>

      <a class="download-btn" href="?export=csv&filter=<?= urlencode($filter) ?>">
         Download Result (<?= number_format($totalVotes) ?> votes)
      </a>

      <form method="GET" class="filter-form" action="">
        <input 
          type="text" 
          name="filter" 
          placeholder="Filter candidates by name..." 
          value="<?= htmlspecialchars($filter) ?>"
          autocomplete="off"
        />
        <button type="submit">Search</button>
      </form>

      <table>
        <thead>
          <tr>
            <th>Candidate Name</th>
            <th>Votes</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($candidates) > 0): ?>
            <?php foreach ($candidates as $cand): ?>
              <tr>
                <td><?= htmlspecialchars($cand['name']) ?></td>
                <td><?= number_format($cand['vote_count']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="2" style="text-align:center; color:#555;">No candidates found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>

