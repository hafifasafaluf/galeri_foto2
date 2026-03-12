@extends('layouts.app')

@section('title', 'Albums')

@section('content')
<div class="box">
    <h2 class="subtitle">Daftar Album</h2>
    <table class="table is-fullwidth is-striped" id="albums-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Album</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
                <th>UserID</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="box">
    <h2 class="subtitle">Tambah / Update Album</h2>
    <form id="album-form">
        <input type="hidden" id="album-id" />

        <div class="field">
            <label class="label">Nama Album</label>
            <div class="control">
                <input class="input" id="field-nama" required />
            </div>
        </div>

        <div class="field">
            <label class="label">Deskripsi</label>
            <div class="control">
                <textarea class="textarea" id="field-deskripsi"></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Tanggal Dibuat</label>
            <div class="control">
                <input class="input" id="field-tanggal" type="date" required />
            </div>
        </div>

        <div class="field">
            <label class="label">UserID</label>
            <div class="control">
                <input class="input" id="field-userid" type="number" required />
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
    const apiBase = '/api/albums';

    async function fetchAlbums() {
        const res = await fetch(apiBase);
        const data = await res.json();
        const tbody = document.querySelector('#albums-table tbody');
        tbody.innerHTML = '';

        data.forEach(a => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${a.AlbumID}</td>
                <td>${a.NamaAlbum}</td>
                <td>${a.Deskripsi}</td>
                <td>${a.TanggalDibuat}</td>
                <td>${a.UserID}</td>
                <td>
                    <button class="button is-small is-info" data-id="${a.AlbumID}" data-action="edit">Edit</button>
                    <button class="button is-small is-danger" data-id="${a.AlbumID}" data-action="delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function saveAlbum(event) {
        event.preventDefault();
        const id = document.getElementById('album-id').value;
        const payload = {
            NamaAlbum: document.getElementById('field-nama').value,
            Deskripsi: document.getElementById('field-deskripsi').value,
            TanggalDibuat: document.getElementById('field-tanggal').value,
            UserID: parseInt(document.getElementById('field-userid').value, 10),
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        resetForm();
        await fetchAlbums();
    }

    async function deleteAlbum(id) {
        await fetch(`${apiBase}/${id}`, { method: 'DELETE' });
        await fetchAlbums();
    }

    async function editAlbum(id) {
        const res = await fetch(`${apiBase}/${id}`);
        const a = await res.json();
        document.getElementById('album-id').value = a.AlbumID;
        document.getElementById('field-nama').value = a.NamaAlbum;
        document.getElementById('field-deskripsi').value = a.Deskripsi;
        document.getElementById('field-tanggal').value = a.TanggalDibuat;
        document.getElementById('field-userid').value = a.UserID;
    }

    function resetForm() {
        document.getElementById('album-form').reset();
        document.getElementById('album-id').value = '';
    }

    document.getElementById('album-form').addEventListener('submit', saveAlbum);
    document.getElementById('reset-form').addEventListener('click', resetForm);

    document.querySelector('#albums-table').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const id = button.getAttribute('data-id');
        const action = button.getAttribute('data-action');

        if (action === 'edit') return editAlbum(id);
        if (action === 'delete') return deleteAlbum(id);
    });

    fetchAlbums();
</script>
@endsection
