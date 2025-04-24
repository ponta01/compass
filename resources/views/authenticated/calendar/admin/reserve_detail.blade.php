<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    @foreach($reservePersons as $person)
    <p><span>{{ $person->setting_reserve }}日</span>
    <span class="ml-3">{{ $person->setting_part }}部</span></p>
    @endforeach
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <span class="detail-group">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th></span>
        </tr>
        @foreach($reservePersons as $person)
        <tr class="text-line">
          <td class="w-25">{{ $person->id }}</td>
          <td class="w-25">{{ $person->limit_users }}</td>
          <td class="w-25">リモート</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
</x-sidebar>
