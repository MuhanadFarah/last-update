<?php
session_start();
require 'dB.php';

header('Content-Type: text/html; charset=utf-8');

// ========== HANDLE EDIT/DELETE ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $action = $_POST['action'];
    $id = trim($_POST['id'] ?? '');

    if ($id === '') {
        echo json_encode(['success' => false, 'message' => 'Missing admin ID.']);
        exit;
    }

    if ($action === 'edit') {
        $phone = trim($_POST['phone'] ?? '');
        if ($phone === '') {
            echo json_encode(['success' => false, 'message' => 'Phone is required.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE admins SET phone = ? WHERE id = ?");
        $stmt->bind_param("si", $phone, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed.']);
        }
        exit;
    }

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
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

// ========== FILTER ==========
$filterPhone = $_GET['phone'] ?? '';

$sql = "SELECT id, phone FROM admins";
if ($filterPhone !== '') {
    $sql .= " WHERE phone LIKE ?";
    $stmt = $conn->prepare($sql);
    $param = "%$filterPhone%";
    $stmt->bind_param("s", $param);
} else {
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Admins</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://thumbnails.texastribune.org/R36UcFndpIhWd_wIQHd_ZYPYcrE=/850x570/smart/filters:quality(75)/https://static.texastribune.org/media/files/38376cc2242905b04b3d17249dc9b0aa/Tarrant%20County%20Election%20Day%20ST%20TT%2035%20EDIT.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 30px;
    }
    .top-buttons {
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1000;
    }
    .top-buttons a {
      background-color: #6c757d;
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .top-buttons a:hover {
      background-color: #495057;
    }
    .container {
      max-width: 800px;
      margin: 80px auto 0;
      background: rgba(255, 255, 255, 0.96);
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    form {
      text-align: center;
      margin-bottom: 15px;
    }
    form input {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 220px;
      font-size: 15px;
    }
    form button {
      padding: 8px 16px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      margin-left: 8px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th {
      background-color: #007bff;
      color: white;
      padding: 10px;
    }
    td {
      padding: 10px;
    }
    .action-btn {
      padding: 5px 10px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: bold;
      margin-right: 5px;
    }
    .edit-btn { background: #17a2b8; color: white; }
    .save-btn { background: #28a745; color: white; }
    .cancel-btn { background: #6c757d; color: white; }
    .delete-btn { background: #dc3545; color: white; }
  </style>
</head>
<body>

<div class="top-buttons">
  <a href="dashboard.php">← Back</a>
</div>

<div class="container">
  <h2>Admin List</h2>

  <form method="GET">
    <input type="text" name="phone" placeholder="Search by Phone" value="<?= htmlspecialchars($filterPhone) ?>" />
    <button type="submit">Filter</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Phone</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr data-id="<?= $row['id'] ?>">
        <td><?= $row['id'] ?></td>
        <td class="aphone"><?= htmlspecialchars($row['phone']) ?></td>
        <td>
          <button class="action-btn edit-btn">Edit</button>
          <button class="action-btn delete-btn">Delete</button>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
function bindAdminActions() {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const tr = btn.closest('tr');
      const id = tr.dataset.id;
      const phoneCell = tr.querySelector('.aphone');
      const currentPhone = phoneCell.textContent.trim();

      phoneCell.innerHTML = `<input type="text" value="${currentPhone}" />`;

      const actionsCell = btn.parentElement;
      actionsCell.innerHTML = '';

      const saveBtn = document.createElement('button');
      saveBtn.textContent = 'Save';
      saveBtn.className = 'action-btn save-btn';

      const cancelBtn = document.createElement('button');
      cancelBtn.textContent = 'Cancel';
      cancelBtn.className = 'action-btn cancel-btn';

      actionsCell.appendChild(saveBtn);
      actionsCell.appendChild(cancelBtn);

      cancelBtn.onclick = () => window.location.reload();

      saveBtn.onclick = async () => {
        const newPhone = phoneCell.querySelector('input').value.trim();
        if (!newPhone) {
          alert('Phone is required.');
          return;
        }

        const formData = new FormData();
        formData.append('action', 'edit');
        formData.append('id', id);
        formData.append('phone', newPhone);

        const res = await fetch('view_admins.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
          phoneCell.textContent = newPhone;
          actionsCell.innerHTML = `
            <button class="action-btn edit-btn">Edit</button>
            <button class="action-btn delete-btn">Delete</button>
          `;
          bindAdminActions();
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

      if (!confirm('Delete admin ID ' + id + '?')) return;

      const formData = new FormData();
      formData.append('action', 'delete');
      formData.append('id', id);

      const res = await fetch('view_admins.php', { method: 'POST', body: formData });
      const data = await res.json();

      if (data.success) {
        tr.remove();
      } else {
        alert(data.message || 'Delete failed.');
      }
    });
  });
}
bindAdminActions();
</script>

</body>
</html>


