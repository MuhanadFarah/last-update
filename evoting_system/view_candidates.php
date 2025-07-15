<?php
session_start();
require 'dB.php';

header('Content-Type: text/html; charset=utf-8');

// ==================== HANDLE AJAX EDIT/DELETE ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $action = $_POST['action'];
    $id = trim($_POST['id'] ?? '');

    if ($id === '') {
        echo json_encode(['success' => false, 'message' => 'Missing candidate ID.']);
        exit;
    }

    if ($action === 'edit') {
        $name = trim($_POST['name'] ?? "");

        if ($name === '') {
            echo json_encode(['success' => false, 'message' => 'Name is required.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE candidates SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed.']);
        }
        exit;
    }

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Delete failed.']);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

// ==================== FILTERING & EXPORT ====================
$filterId = $_GET['id'] ?? '';
$filterName = $_GET['name'] ?? '';

$where = [];
$params = [];
$types = '';

if ($filterId !== '') {
    $where[] = "id LIKE ?";
    $params[] = "%$filterId%";
    $types .= 's';
}
if ($filterName !== '') {
    $where[] = "name LIKE ?";
    $params[] = "%$filterName%";
    $types .= 's';
}

$sql = "SELECT id, name FROM candidates";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id ASC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="candidates.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name']);
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Candidates</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://somalipublicagenda.org/wp-content/uploads/2024/12/Informing-Somalias-Election-Laws.png.webp') no-repeat center center fixed;
      background-size: cover;
      padding: 30px;
      margin: 0;
      min-height: 100vh;
    }
    .btn-back {
      position: fixed;
      top: 15px;
      left: 15px;
      background-color: #6c757d;
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      z-index: 1000;
    }
    .btn-back:hover {
      background-color: #495057;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
      margin-top: 60px;
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #222;
    }
    form {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
    }
    form input {
      padding: 7px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    form button, .export-btn {
      background: #007BFF;
      color: white;
      border: none;
      padding: 7px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
      font-size: 14px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background: #007BFF;
      color: white;
    }
    .action-btn {
      margin-right: 5px;
      padding: 5px 10px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: bold;
      font-size: 13px;
    }
    .edit-btn {
      background: #17a2b8;
      color: white;
    }
    .save-btn {
      background: #28a745;
      color: white;
    }
    .cancel-btn {
      background: #6c757d;
      color: white;
    }
    .delete-btn {
      background: #dc3545;
      color: white;
    }
  </style>
</head>
<body>
  <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
  <div class="container">
    <h2>Candidate List</h2>

    <form method="GET">
      <input type="text" name="id" placeholder="Candidate ID" value="<?= htmlspecialchars($filterId) ?>" />
      <input type="text" name="name" placeholder="Candidate Name" value="<?= htmlspecialchars($filterName) ?>" />
      <button type="submit">Filter</button>
      <a href="view_candidates.php?export=csv&id=<?= urlencode($filterId) ?>&name=<?= urlencode($filterName) ?>" class="export-btn">Export CSV</a>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr data-id="<?= htmlspecialchars($row['id']) ?>">
          <td class="cid"><?= htmlspecialchars($row['id']) ?></td>
          <td class="cname"><?= htmlspecialchars($row['name']) ?></td>
          <td class="actions-cell">
            <button class="action-btn edit-btn">Edit</button>
            <button class="action-btn delete-btn">Delete</button>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const tr = btn.closest('tr');
      const id = tr.dataset.id;
      const nameCell = tr.querySelector('.cname');
      const actionsCell = tr.querySelector('.actions-cell');
      const currentName = nameCell.textContent.trim();

      nameCell.innerHTML = `<input type="text" value="${currentName}" style="width: 100%;" />`;
      actionsCell.innerHTML = ''; // clear

      const saveBtn = document.createElement('button');
      saveBtn.className = 'action-btn save-btn';
      saveBtn.textContent = 'Save';

      const cancelBtn = document.createElement('button');
      cancelBtn.className = 'action-btn cancel-btn';
      cancelBtn.textContent = 'Cancel';

      actionsCell.appendChild(saveBtn);
      actionsCell.appendChild(cancelBtn);

      cancelBtn.onclick = () => window.location.reload();

      saveBtn.onclick = async () => {
        const newName = nameCell.querySelector('input').value.trim();
        if (newName === '') return alert("Name cannot be empty.");

        const formData = new FormData();
        formData.append('action', 'edit');
        formData.append('id', id);
        formData.append('name', newName);

        const res = await fetch('view_candidates.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
          nameCell.textContent = newName;
          actionsCell.innerHTML = `
            <button class="action-btn edit-btn">Edit</button>
            <button class="action-btn delete-btn">Delete</button>
          `;
          bindEditDelete();
        } else {
          alert(data.message || 'Update failed');
        }
      };
    });
  });

  function bindEditDelete() {
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.onclick = async () => {
        const tr = btn.closest('tr');
        const id = tr.dataset.id;

        if (!confirm('Delete candidate ID ' + id + '?')) return;

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        const res = await fetch('view_candidates.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
          tr.remove();
        } else {
          alert(data.message || 'Delete failed.');
        }
      };
    });
  }

  bindEditDelete();
  </script>
</body>
</html>
