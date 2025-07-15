<?php
session_start();
require 'dB.php';

header('Content-Type: text/html; charset=utf-8');

// ==================== HANDLE AJAX EDIT/DELETE ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];

    $old_id = trim($_POST['old_id'] ?? '');
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $faculty = trim($_POST['faculty'] ?? '');

    if ($action === 'edit') {
        if ($old_id === '' || $id === '' || $name === '' || $faculty === '') {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE students SET id = ?, name = ?, faculty = ? WHERE id = ?");
        $stmt->bind_param("ssss", $id, $name, $faculty, $old_id);

        echo $stmt->execute()
            ? json_encode(['success' => true])
            : json_encode(['success' => false, 'message' => 'Update failed.']);
        exit;
    }

    if ($action === 'delete') {
        if ($id === '') {
            echo json_encode(['success' => false, 'message' => 'Missing student ID.']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("s", $id);

        echo $stmt->execute()
            ? json_encode(['success' => true])
            : json_encode(['success' => false, 'message' => 'Delete failed.']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

// ==================== FILTERING & EXPORT ====================
$filterId = $_GET['id'] ?? '';
$filterName = $_GET['name'] ?? '';
$filterFaculty = $_GET['faculty'] ?? '';

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
if ($filterFaculty !== '') {
    $where[] = "faculty LIKE ?";
    $params[] = "%$filterFaculty%";
    $types .= 's';
}

$sql = "SELECT id, name, faculty FROM students";
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
    header('Content-Disposition: attachment; filename="students.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name', 'Faculty']);
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
  <title>Manage Students</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://images.unsplash.com/photo-1573164574572-cb89e39749b4') no-repeat center center fixed;
      background-size: cover;
      padding: 30px;
      margin: 0;
    }
    .btn-back {
      display: inline-block;
      margin-bottom: 15px;
      padding: 8px 16px;
      background-color: #6c757d;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      text-decoration: none;
    }
    .btn-back:hover {
      background-color: #495057;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
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
    }
    form button, .export-btn {
      background: #007BFF;
      color: white;
      border: none;
      padding: 7px 15px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
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
    }
    .edit-btn { background: #17a2b8; color: white; }
    .save-btn { background: #28a745; color: white; }
    .cancel-btn { background: #6c757d; color: white; }
    .delete-btn { background: #dc3545; color: white; }
  </style>
</head>
<body>
<div class="container">
  <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
  <h2>Student List</h2>

  <form method="GET">
    <input type="text" name="id" placeholder="Student ID" value="<?= htmlspecialchars($filterId) ?>" />
    <input type="text" name="name" placeholder="Name" value="<?= htmlspecialchars($filterName) ?>" />
    <input type="text" name="faculty" placeholder="Faculty" value="<?= htmlspecialchars($filterFaculty) ?>" />
    <button type="submit">Filter</button>
    <a href="view_students.php?export=csv&id=<?= urlencode($filterId) ?>&name=<?= urlencode($filterName) ?>&faculty=<?= urlencode($filterFaculty) ?>" class="export-btn">Export CSV</a>
  </form>

  <table id="students-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Faculty</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr data-id="<?= htmlspecialchars($row['id']) ?>">
        <td class="sid"><?= htmlspecialchars($row['id']) ?></td>
        <td class="sname"><?= htmlspecialchars($row['name']) ?></td>
        <td class="sfaculty"><?= htmlspecialchars($row['faculty']) ?></td>
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
function bindStudentActions() {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const tr = btn.closest('tr');
      const oldId = tr.dataset.id;
      const idCell = tr.querySelector('.sid');
      const nameCell = tr.querySelector('.sname');
      const facultyCell = tr.querySelector('.sfaculty');

      const idVal = idCell.textContent.trim();
      const nameVal = nameCell.textContent.trim();
      const facultyVal = facultyCell.textContent.trim();

      idCell.innerHTML = `<input type="text" value="${idVal}" />`;
      nameCell.innerHTML = `<input type="text" value="${nameVal}" />`;
      facultyCell.innerHTML = `<input type="text" value="${facultyVal}" />`;

      const actions = tr.querySelector('.actions-cell');
      actions.innerHTML = '';

      const saveBtn = document.createElement('button');
      saveBtn.textContent = 'Save';
      saveBtn.className = 'action-btn save-btn';

      const cancelBtn = document.createElement('button');
      cancelBtn.textContent = 'Cancel';
      cancelBtn.className = 'action-btn cancel-btn';

      actions.appendChild(saveBtn);
      actions.appendChild(cancelBtn);

      cancelBtn.onclick = () => window.location.reload();

      saveBtn.onclick = async () => {
        const newId = idCell.querySelector('input').value.trim();
        const newName = nameCell.querySelector('input').value.trim();
        const newFaculty = facultyCell.querySelector('input').value.trim();

        if (!newId || !newName || !newFaculty) {
          alert('All fields are required.');
          return;
        }

        const formData = new FormData();
        formData.append('action', 'edit');
        formData.append('old_id', oldId);
        formData.append('id', newId);
        formData.append('name', newName);
        formData.append('faculty', newFaculty);

        const res = await fetch('view_students.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
          idCell.textContent = newId;
          nameCell.textContent = newName;
          facultyCell.textContent = newFaculty;
          tr.dataset.id = newId;

          actions.innerHTML = `
            <button class="action-btn edit-btn">Edit</button>
            <button class="action-btn delete-btn">Delete</button>
          `;
          bindStudentActions();
        } else {
          alert(data.message || 'Update failed.');
        }
      };
    });
  });

  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const tr = btn.closest('tr');
      const id = tr.dataset.id;

      if (!confirm('Delete student ID ' + id + '?')) return;

      const formData = new FormData();
      formData.append('action', 'delete');
      formData.append('id', id);

      const res = await fetch('view_students.php', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.success) {
        tr.remove();
      } else {
        alert(data.message || 'Delete failed.');
      }
    });
  });
}
bindStudentActions();
</script>
</body>
</html>
