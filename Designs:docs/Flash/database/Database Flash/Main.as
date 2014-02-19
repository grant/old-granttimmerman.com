package {
	import flash.display.MovieClip;
	
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	public class Main extends MovieClip  {
	public var req:URLRequest = new URLRequest("http://www.granttimmerman.com/oldFiles/Tests/flashDatabase/sendTest.php");
		public function Main():void {
			
		}
		public function sendReq():void {
			output.text = "Pending...";
			
			var loader:URLLoader = new URLLoader();
			var vars:URLVariables = new URLVariables();
			
			loader.addEventListener(Event.COMPLETE, loadComplete);
			loader.addEventListener(IOErrorEvent.IO_ERROR, loadError);
			
			vars.string = input.text;
			
			req.method = URLRequestMethod.POST;
			req.data = vars;
		}
		private function loadComplete(e:Event):void {
			output.text = "sent";
			trace(req.data.string);
		}
		private function loadError(e:IOErrorEvent):void {
			output.text = "message failed";
		}		
	}
}