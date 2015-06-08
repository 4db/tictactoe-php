Users online:
<ul>
	{foreach from=$users item=value}
		<li>
			{if isset($value.currentUser) && $value.currentUser === true}
				<b>{$value.name}</b>
			{else}
				{$value.name}
				{if $value.is_play === "0"}
					<input class="play" type="button" value="play" onclick="play({$value.id})">
				{/if}
			{/if}
		</li>
	{/foreach}
</ul>
