<div class="row">
  <div class="col-md-6 mb-3">
    <label>Nome</label>
    <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" required>
  </div>
  <div class="col-md-6 mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control" required>
  </div>
  <div class="col-md-6 mb-3">
    <label>Telefone</label>
    <input type="text" name="phone_number" value="{{ old('phone_number', $supplier->phone_number ?? '') }}"
      class="form-control" required>
  </div>
  <div class="col-md-6 mb-3">
    <label>Rua</label>
    <input type="text" name="street" value="{{ old('street', $supplier->street ?? '') }}" class="form-control" required>
  </div>
  <div class="col-md-4 mb-3">
    <label>Cidade</label>
    <input type="text" name="city" value="{{ old('city', $supplier->city ?? '') }}" class="form-control" required>
  </div>
  <div class="col-md-2 mb-3">
    <label>Estado</label>
    <input type="text" name="state" value="{{ old('state', $supplier->state ?? '') }}" class="form-control" required>
  </div>
  <div class="col-md-4 mb-3">
    <label>CEP</label>
    <input type="text" name="zip_code" value="{{ old('zip_code', $supplier->zip_code ?? '') }}" class="form-control"
      required>
  </div>
  <div class="col-md-2 mb-3">
    <label>Status</label>
    <select name="is_active" class="form-control">
      <option value="1" {{ (old('is_active', $supplier->is_active ?? 1) == 1) ? 'selected' : '' }}>Ativo</option>
      <option value="0" {{ (old('is_active', $supplier->is_active ?? 1) == 0) ? 'selected' : '' }}>Inativo</option>
    </select>
  </div>
</div>
