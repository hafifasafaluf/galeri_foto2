@extends('layouts.app')

@section('title', 'Komentar Foto')

@section('content')
<div class="box">
    <h2 class="subtitle">Daftar Komentar</h2>
    <table class="table is-fullwidth is-striped" id="komentar-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>FotoID</th>
                <th>UserID</th>
                <th>Isi Komentar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="box">
    <h2 class="subtitle">Tambah / Update Komentar</h2>
    <form id="komentar-form">
        <input type="hidden" id="komentar-id" />

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
            <label class="label">Isi Komentar</label>
            <div class="control">
                <textarea class="textarea" id="field-isi" required></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label">Tanggal Komentar</label>
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
    const apiBase = '/api/komentar';

    async function fetchKomentar() {
        const res = await fetch(apiBase);
        const data = await res.json();
        const tbody = document.querySelector('#komentar-table tbody');
        tbody.innerHTML = '';

        data.forEach(k => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${k.KomentarID}</td>
                <td>${k.FotoID}</td>
                <td>${k.UserID}</td>
                <td>${k.IsiKomentar}</td>
                <td>${k.TanggalKomentar}</td>
                <td>
                    <button class="button is-small is-info" data-id="${k.KomentarID}" data-action="edit">Edit</button>
                    <button class="button is-small is-danger" data-id="${k.KomentarID}" data-action="delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async function saveKomentar(event) {
        event.preventDefault();
        const id = document.getElementById('komentar-id').value;
        const payload = {
            FotoID: parseInt(document.getElementById('field-fotoid').value, 10),
            UserID: parseInt(document.getElementById('field-userid').value, 10),
            IsiKomentar: document.getElementById('field-isi').value,
            TanggalKomentar: document.getElementById('field-tanggal').value,
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        resetForm();
        await fetchKomentar();
    }

    async function deleteKomentar(id) {
        await fetch(`${apiBase}/${id}`, { method: 'DELETE' });
        await fetchKomentar();
    }

    async function editKomentar(id) {
        const res = await fetch(`${apiBase}/${id}`);
        const k = await res.json();
        document.getElementById('komentar-id').value = k.KomentarID;
        document.getElementById('field-fotoid').value = k.FotoID;
        document.getElementById('field-userid').value = k.UserID;
        document.getElementById('field-isi').value = k.IsiKomentar;
        document.getElementById('field-tanggal').value = k.TanggalKomentar;
    }

    function resetForm() {
        document.getElementById('komentar-form').reset();
        document.getElementById('komentar-id').value = '';
    }

    document.getElementById('komentar-form').addEventListener('submit', saveKomentar);
    document.getElementById('reset-form').addEventListener('click', resetForm);

    document.querySelector('#komentar-table').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const id = button.getAttribute('data-id');
        const action = button.getAttribute('data-action');

        if (action === 'edit') return editKomentar(id);
        if (action === 'delete') return deleteKomentar(id);
    });

    fetchKomentar();
</script>
@endsection
