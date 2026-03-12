@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="box">
    <h2 class="subtitle">Daftar User</h2>
    <table class="table is-fullwidth is-striped" id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="box">
    <h2 class="subtitle">Tambah / Update User</h2>
    <form id="user-form">
        <input type="hidden" id="user-id" />

        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" id="field-username" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" id="field-password" type="password" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" id="field-email" type="email" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Nama Lengkap</label>
            <div class="control">
                <input class="input" id="field-nama" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Alamat</label>
            <div class="control">
                <textarea class="textarea" id="field-alamat"></textarea>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-primary" type="submit">Simpan</button>
            </div>
            <div class="control">
                <button class="button is-light" type="button" id="reset-form">Bersihkan</button>
            </div>
        </div>
    </form>
</div>

<script>
    const apiBase = '/api/users';

    async function fetchUsers() {
        const res = await fetch(apiBase);
        const data = await res.json();
        const tbody = document.querySelector('#users-table tbody');
        tbody.innerHTML = '';

        data.forEach(u => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${u.UserID}</td>
                <td>${u.Username}</td>
                <td>${u.Email}</td>
                <td>${u.NamaLengkap}</td>
                <td>
                    <button class="button is-small is-info" data-id="${u.UserID}" data-action="edit">Edit</button>
                    <button class="button is-small is-danger" data-id="${u.UserID}" data-action="delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function saveUser(event) {
        event.preventDefault();
        const id = document.getElementById('user-id').value;
        const payload = {
            Username: document.getElementById('field-username').value,
            Password: document.getElementById('field-password').value,
            Email: document.getElementById('field-email').value,
            NamaLengkap: document.getElementById('field-nama').value,
            Alamat: document.getElementById('field-alamat').value,
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        resetForm();
        await fetchUsers();
    }

    async function deleteUser(id) {
        await fetch(`${apiBase}/${id}`, { method: 'DELETE' });
        await fetchUsers();
    }

    async function editUser(id) {
        const res = await fetch(`${apiBase}/${id}`);
        const u = await res.json();
        document.getElementById('user-id').value = u.UserID;
        document.getElementById('field-username').value = u.Username;
        document.getElementById('field-password').value = '';
        document.getElementById('field-email').value = u.Email;
        document.getElementById('field-nama').value = u.NamaLengkap;
        document.getElementById('field-alamat').value = u.Alamat;
    }

    function resetForm() {
        document.getElementById('user-form').reset();
        document.getElementById('user-id').value = '';
    }

    document.getElementById('user-form').addEventListener('submit', saveUser);
    document.getElementById('reset-form').addEventListener('click', resetForm);

    document.querySelector('#users-table').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const id = button.getAttribute('data-id');
        const action = button.getAttribute('data-action');

        if (action === 'edit') return editUser(id);
        if (action === 'delete') return deleteUser(id);
    });

    fetchUsers();
</script>
@endsection
