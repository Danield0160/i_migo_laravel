<form action="{{route ('language.switch')}}" method="POST">
    @csrf
    <select name="language" onchange="this.form.submit()">
        <option value="en" {{app()->getLocale() === 'en' ? 'selected' : ''}}> English</option>
        <option value="es" {{app()->getLocale() === 'es' ? 'selected' : ''}}> Español</option>
    </select>
</form>