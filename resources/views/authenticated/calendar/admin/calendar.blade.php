<x-sidebar>
<div class="vh-90 pt-4" style="background:#ECF1F6;">
  <div class="border w-75 h-95 m-auto pt-4" style="border-radius:5px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto" style="border-radius:5px;">
      <a href="javascript:void(0);">{!! $calendar->render() !!}</a>
  </div>
</div>
</x-sidebar>
