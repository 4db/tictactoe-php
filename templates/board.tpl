{assign var="turn" value=false}

	You play
	{if $info.id == $info.user_x_id}
		X,
		{if $info.turn_x === '1'}
			you turn.
			{assign var="char" value='X'}
			{assign var="turn" value=true}
		{else}
			turn O.
		{/if}
	{else}
		O,
		{if $info.turn_o === '1'}
			you turn.
			{assign var="char" value='O'}
			{assign var="turn" value=true}
		{else}
			turn X.
		{/if}
	{/if}

<br>
{if $info.status === '1'}
	X win!
{elseif $info.status === '2'}
	O win!
{elseif $info.status === '3'}
	Cat's game
{/if}

	<br>

	<table>
		{foreach from=$info.board item=arr}
			<tr>
				{foreach from=$arr item=item}
					<td {if $item === '0' && $turn === true && $info.status === '0'}
						onclick="game(this, '{$char}');"
						{/if}>
						{if $item !== '0'}
							{if $item ==='1'}
								X
							{else}
								O
							{/if}
						{/if}
					</td>
				{/foreach}
			</tr>
		{/foreach}
	</table>

{if $info.status === '0'}
<script language="javascript">
	var stop = false;
	function game(el, ch){

		if (stop) return false;
		el.innerText = ch;

		tds = document.getElementsByTagName('td');
		arr = Array.apply(null, new Array(3)).map(function(val, i) {
			return Array.apply(null, new Array(3)).map(function(val, j) {
				if(i != 0) j=j+3*i;
				if(tds[j].innerText === 'X') return 1;
				if(tds[j].innerText === 'O') return 2;
				return 0;
			});
		});
		var board = arr.join('-').replace("/,/g",'');

		$.ajax({
			type: 'POST',
			url: host,
			data: {
				board: board,
				fromUserId:userId,
				char:ch
			},
			dataType: 'json',
			success: function (data) {
				console.log(data);
			}
		});
		stop = true;
	}
</script>
{/if}
