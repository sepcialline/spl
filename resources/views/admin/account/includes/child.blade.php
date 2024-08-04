<li><span class="caret">{{ $child_account->account_name }}</span> <span>{{$child_account->account_code}}</span>
    @if($child_account->account_code == 121)

    @else
    <a href="{{ route('admin.account.edit', $child_account->id) }}">
        <span style="cursor: pointer;"><i class='bx bxs-pencil'></i></span>
    </a>
    @endif
    @if ($child_account->accounts)
        <ul class="nested">
            @foreach ($child_account->accounts as $childAccount)
                @include('admin.account.includes.child', ['child_account' => $childAccount])
            @endforeach
        </ul>
    @endif
<li>
