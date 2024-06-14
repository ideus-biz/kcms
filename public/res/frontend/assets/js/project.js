/*
$(document).ready(function () {

});

$(window).resize(function() {

});

$(window).load(function () {

});
*/

window.onload = function () {
	$(function () {
		let undoTm;
		let undoLastVal = null;
		const undoList = [];
		
		const $text = $('#textBox');
		
		if (!empty($text))
		{
			//undoList.push($text.val());
			
			$text.on('keydown', function (e) {
				const event = e.originalEvent;
				const $this = $(this);
				const cursorPos = $this.prop('selectionStart');
				let html = $this.val();
				
				if (event.code === 'KeyZ' && event.ctrlKey && !event.shiftKey && !event.metaKey)
				{
					//e.preventDefault(true);
					if (undoList.length > 0)
					{
						$this.val(undoList.pop());
						$this.prop('selectionStart', cursorPos);
						$this.prop('selectionEnd', cursorPos);
						console.log('undo', undoList.length);
					}
					
					return;
				}
				
				undoLastVal = html;
				
				if (event.keyCode === 8 && !event.shiftKey)
				{
					const isInStr = editorIsInQuotes(html, cursorPos);
					let nextChar = '';
					if (html[cursorPos - 1] === '{' && !isInStr) nextChar = '}';
					else if (html[cursorPos - 1] === '[' && !isInStr) nextChar = ']';
					else if (html[cursorPos - 1] === '"' && (!isInStr || html[cursorPos] === '"' && html[cursorPos-2] !== '\\')) nextChar = '"';
					
					if (nextChar && html[cursorPos] === nextChar) {
						e.preventDefault(true);
						
						const newHtml = html.substring(0, cursorPos - 1) + html.substring(cursorPos + 1);
						$this.val(newHtml);
						//undoList.push(newHtml);
						
						$this.prop('selectionStart', cursorPos - 1);
						$this.prop('selectionEnd', cursorPos - 1);
					}
					else if (event.shiftKey) 
					{
						let pos = 0;
						do
						{
							pos++;
							if (html[cursorPos-pos] === "\n")
							{
								e.preventDefault(true);
								const newHtml = html.substring(0, cursorPos-pos) + html.substring(cursorPos);
								$this.val(newHtml);
								//undoList.push(newHtml);
								
								$this.prop('selectionStart', cursorPos - pos);
								$this.prop('selectionEnd', cursorPos - pos);
								break;
							}
						} while (html[cursorPos-pos] === ' ');
					}
					//else undoList.push(html);
				}
				else if (event.keyCode === 13)
				{
					e.preventDefault(true);
					
					let nextChar = '';
					if (html[cursorPos-1] === '{') nextChar = '}';
					else if (html[cursorPos-1] === '[') nextChar = ']';
					
					const tabLen = nextChar ? 2 : 0;
					const ql = editorFindTabLen(html, cursorPos);
					const tab = ' ';
					let newHtml = html.substring(0, cursorPos) + "\n" + tab.repeat(ql+tabLen);
					if (nextChar && html[cursorPos] === nextChar) newHtml = newHtml + "\n" + tab.repeat(ql) + html.substring(cursorPos);
					else newHtml = newHtml + html.substring(cursorPos);
					
					$this.val(newHtml);
					//undoList.push(newHtml);
					
					$this.prop('selectionStart', cursorPos+ql+tabLen+1);
					$this.prop('selectionEnd', cursorPos+ql+tabLen+1);
				}
				else if (event.code === 'KeyE' && event.ctrlKey)
				{
					const line = editorGetThisLine(html, cursorPos);
					console.log(line, html.substring(line.start, line.end));
					const newHtml = html.substring(0, line.start) + html.substring(line.end);
					$this.val(newHtml);
					$this.prop('selectionStart', cursorPos);
					$this.prop('selectionEnd', cursorPos);
				}
			});
			
			
			$text.on('keypress', function (e) {
				const event = e.originalEvent;
				const $this = $(this);
				const cursorPos = $this.prop('selectionStart');
				//console.log(cursorPos);
				let html = $this.val();
				
				//if (html !== undoLastVal) undoList.push(undoLastVal);
				
				const isOnStr = editorIsInQuotes(html, cursorPos);
				let nextChar = '';
				if (!isOnStr) {
					let shift = 1;
					if (event.key === '{') nextChar = '}';
					else if (event.key === '[') nextChar = ']';
					else if (event.key === '"') nextChar = '"';
					else if (event.key === ':') nextChar = ' ';
					if (nextChar) {
						e.preventDefault(true);
						let newHtml;
						
						if (event.key === ':')
						{
							shift++;
							if (html[cursorPos-1] !== '"' && html[cursorPos] === "\n")
							{
								let pos = 1;
								while (cursorPos-pos >= 0 && html[cursorPos-pos] !== "\n" && html[cursorPos-pos] !== ' ') pos++;
								if (cursorPos-pos >= 0) pos--;
								//console.log('>'+html.substring(cursorPos-pos, cursorPos)+'<');
								newHtml = html.substring(0, cursorPos-pos) + '"' + html.substring(cursorPos-pos, cursorPos) + '"' + event.key + nextChar + html.substring(cursorPos);
								shift = shift+2;
							}
						}
						
						if (!newHtml) newHtml = html.substring(0, cursorPos) + event.key + nextChar + html.substring(cursorPos);
						
						$this.val(newHtml);
						//undoList.push(newHtml);
						$this.prop('selectionStart', cursorPos + shift);
						$this.prop('selectionEnd', cursorPos + shift);
						return;
					}
				}
				
				if (!isOnStr && event.key === '}') nextChar = '}';
				else if (!isOnStr && event.key === ']') nextChar = ']';
				else if (event.key === '"') nextChar = '"';
				if (nextChar && html[cursorPos] === nextChar)
				{
					e.preventDefault(true);
					$this.prop('selectionStart', cursorPos + 1);
					$this.prop('selectionEnd', cursorPos + 1);
					return;
				}
				
				//
				//undoList.push($this.val());
				/*if (undoTm) clearTimeout(undoTm); 
				undoTm = setTimeout(()=>{
					const html = $this.val();
					undoList.push(html);
					console.log(undoList.length, html);
				}, 100);*/
			});
		}
	});
};


$(window).on('kcmsReady', function () {
	ActiveWidget.EventOn('activated', function (zone)
	{
		
	});
});


function editorFindTabLen(text, pos) {
	let ret = 0;
	pos--;
	while (text[pos] !== "\n" && pos >= 0)
	{
		if (text[pos] === ' ') ret++;
		else if (text[pos] !== "\n") ret = 0;
		pos--;
	}

	return ret;
}

function editorIsInQuotes(text, pos) {
	const len = text.length;
	let ret = [false, false];
	let n = 0;
	while((pos+n < len || pos-n >= 0) && (!ret[0] || !ret[1]))
	{
		if (ret[0] === false && pos-n >= 0 && text[pos-n] === '"' && text[pos-n-1] !== '\\') ret[0] = true;
		if (ret[1] === false && pos+n < len && text[pos+n] === '"' && text[pos+n-1] !== '\\') ret[1] = true;
		n++;
	} 
	
	return ret[0] && ret[1];
}

function editorGetThisLine(text, pos) {
	const len = text.length;
	let ret = {
		start: false,
		end: false,
	};
	
	let n = 0;
	while((pos+n < len || pos-n >= 0) && (!ret.start || !ret.end))
	{
		if (ret.start === false && pos-n-1 >= 0 && text[pos-n-1] === "\n") ret.start = pos-n+1;
		if (ret.end === false && pos+n < len && text[pos+n] === "\n") ret.end = pos+n+1;
		n++;
	}
	
	if (ret.start === false || ret.start >= len) ret.start = 0;
	if (ret.end === false || ret.end >= len) ret.end = len;
	
	return ret;
}

