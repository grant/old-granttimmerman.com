package {
	import flash.display.MovieClip;

	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.events.IOErrorEvent;

	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	public class Main extends MovieClip {
		private var scriptURL:String="http://www.granttimmerman.com/xml.php";
		public function Main():void {
			addEventListener(Event.ADDED_TO_STAGE,onAdd);
		}
		private function onAdd(e:Event):void {
			stage.addEventListener(MouseEvent.CLICK,onClick);
			removeEventListener(Event.ADDED_TO_STAGE,onAdd);
		}
		private function onClick(e:MouseEvent):void {
			output.appendText(".");
			loadXML();
			//loadURL(scriptURL);
		}
		
		
		private function loadXML():void {
			var xmlLoader:URLLoader = new URLLoader();
			xmlLoader.addEventListener(Event.COMPLETE, showXML);
			xmlLoader.load(new URLRequest("http://www.granttimmerman.com/xml.php"));
		}
		function showXML(e:Event):void {
			XML.ignoreWhitespace=true;
			var base:XML=new XML(e.target.data);
			for (var i:uint=0; i < base.length(); i++) {
				output.appendText(base.e[i].text());
			}
		}




		private function loadURL(url:String):void {
			var loader:URLLoader = new URLLoader();
			var req:URLRequest=new URLRequest(url);

			var vars:URLVariables = new URLVariables();
			vars.postVar="Hello World";

			req.method=URLRequestMethod.POST;
			req.data=vars;

			loader.dataFormat="text";
			loader.addEventListener(Event.COMPLETE, handleReturnResponse);
			loader.addEventListener(IOErrorEvent.IO_ERROR, loadError);

			loader.load(req);
		}
		private function handleReturnResponse( event:Event ):void {
			var returned:String=XML(event.target).toXMLString();
			output.text=returned;
		}
		private function loadError(e:IOErrorEvent):void {
			output.text="Error occured.";
		}
	}
}