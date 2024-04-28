<form action="{{ route('language.switch') }}" method="POST" class="form-inline">
    @csrf
    <div class="form-group">
        <select name="language" class="form-control" onchange="this.form.submit()">
            <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
            <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>Español</option>
        </select>
    </div>
</form>
