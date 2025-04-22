<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>日</span>
    @if($isPastDate)
        <p class="status text-danger">受付終了</p>
    @else
        <p class="status text-success">受付中</p>
    @endif
    <span class="ml-3">部</span></p>
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
        </tr>
        @foreach($reservePersons as $person)
        <tr class="text-center">
          <td class="w-25">{{ $person->id }}</td>
          <td class="w-25">{{ $person->name }}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
</x-sidebar>
