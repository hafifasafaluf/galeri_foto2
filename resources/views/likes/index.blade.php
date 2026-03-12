@extends('layouts.app')

@section('title', 'Likes')

@section('content')
<div class="box">
    <h2 class="subtitle">Daftar Likes</h2>
    <table class="table is-fullwidth is-striped" id="likes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>FotoID</th>
                <th>UserID</th>
                <th>Tanggal Like</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="box">
    <h2 class="subtitle">Tambah Like</h2>
    <form id="like-form">
        <input type="hidden" id="like-id" />

        <div class="field">
            <label class="label">FotoID</label>
            <div class="control">
                <input class="input" id="field-fotoid" type="number" required />
            </div>
        </div>

        <div class="field">
            <label class="label">UserID</label>
            <div class="control">
                <input class="input" id="field-userid" type="number" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Tanggal Like</label>
            <div class="control">
                <input class="input" id="field-tanggal" type="date" required />
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
    const apiBase = '/api/likes';

    async function fetchLikes() {
        const res = await fetch(apiBase);
        const data = await res.json();
        const tbody = document.querySelector('#likes-table tbody');
        tbody.innerHTML = '';

        data.forEach(l => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${l.LikeID}</td>
                <td>${l.FotoID}</td>
                <td>${l.UserID}</td>
                <td>${l.TanggalLike}</td>
                <td>
                    <button class="button is-small is-info" data-id="${l.LikeID}" data-action="edit">Edit</button>
                    <button class="button is-small is-danger" data-id="${l.LikeID}" data-action="delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function saveLike(event) {
        event.preventDefault();
        const id = document.getElementById('like-id').value;
        const payload = {
            FotoID: parseInt(document.getElementById('field-fotoid').value, 10),
            UserID: parseInt(document.getElementById('field-userid').value, 10),
            TanggalLike: document.getElementById('field-tanggal').value,
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        resetForm();
        await fetchLikes();
    }

    async function deleteLike(id) {
        await fetch(`${apiBase}/${id}`, { method: 'DELETE' });
        await fetchLikes();
    }

    async function editLike(id) {
        const res = await fetch(`${apiBase}/${id}`);
        const l = await res.json();
        document.getElementById('like-id').value = l.LikeID;
        document.getElementById('field-fotoid').value = l.FotoID;
        document.getElementById('field-userid').value = l.UserID;
        document.getElementById('field-tanggal').value = l.TanggalLike;
    }

    function resetForm() {
        document.getElementById('like-form').reset();
        document.getElementById('like-id').value = '';
    }

    document.getElementById('like-form').addEventListener('submit', saveLike);
    document.getElementById('reset-form').addEventListener('click', resetForm);

    document.querySelector('#likes-table').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const id = button.getAttribute('data-id');
        const action = button.getAttribute('data-action');

        if (action === 'edit') return editLike(id);
        if (action === 'delete') return deleteLike(id);
    });

    fetchLikes();
</script>
@endsection
