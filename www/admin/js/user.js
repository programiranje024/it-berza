async function banUser(userId) {
  const data = await fetch(`/admin/users/ban.php?id=${userId}`);
  const json = await data.json();

  alert(json.message);
  window.location.reload();
}

async function unbanUser(userId) {
  const data = await fetch(`/admin/users/unban.php?id=${userId}`);
  const json = await data.json();

  alert(json.message);
  window.location.reload();
}

async function deleteUser(userId) {
  const data = await fetch(`/admin/users/delete.php?id=${userId}`);
  const json = await data.json();

  alert(json.message);
  window.location.reload();
}

async function verifyUser(userId) {
  const data = await fetch(`/admin/users/verify.php?id=${userId}`);
  const json = await data.json();

  alert(json.message);
  window.location.reload();
}
