<h4>{{ __('Nodes I follow') }}</h4>
<ul class="list-unstyled node-list mt-4">
    @foreach($nodes as $node)
    <li>
        <div class="row no-gutters">
            <div class="col-2">
                <i class="fa fa-asterisk icon-green" aria-hidden="true"></i>
            </div>
            <a href="#">
                <small class="col black-87">{{ $node->name }}</small>
            </a>
        </div>
    </li>
    @endforeach
</ul>
