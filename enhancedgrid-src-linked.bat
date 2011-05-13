@echo off

pushd .  
%~d0     
cd %~dp0 

REM put this file in the Magento installation directory      

REM point this to the path of all the BSS files as an absolute path.

set source_path=C:\dev\prog\mmeg

REM remove old links or files
rd  /s /q  .\app\code\community\TBT\Enhancedgrid
del /s /q  .\app\design\adminhtml\default\default\layout\tbt_enhancedgrid.xml
rd  /s /q  .\app\design\adminhtml\default\default\template\tbt
REM del /s /q  .\app\design\frontend\default\default\layout\enhancedgrid.xml
REM rd  /s /q  .\app\design\frontend\default\default\template\tbt
del /s /q  .\app\etc\modules\TBT_Enhancedgrid.xml
rd  /s /q  .\skin\frontend\default\default\css\enhancedgrid
rd  /s /q  .\skin\frontend\default\default\images\enhancedgrid     
rd  /s /q  .\skin\adminhtml\default\default\css\enhancedgrid
rd  /s /q  .\skin\adminhtml\default\default\images\enhancedgrid    
rd /s /q   .\js\tbt\enhancedgrid

REM rebuild directory struct  
md         .\app\code\community\TBT                            
md         .\app\design\adminhtml\default\default\layout\   
md         .\app\design\adminhtml\default\default\template     
md         .\app\design\frontend\default\default\layout\    
md         .\app\design\frontend\default\default\template      
md         .\app\design\frontend\default           
md         .\app\etc\modules\                       
md         .\app\locale\en_US\template\email                   
md         .\js                                                    
md         .\skin\frontend\default\default\css                 
md         .\skin\frontend\default\default\fonts\            
md         .\skin\frontend\default\default\images                 
md         .\skin\adminhtml\default\default\css                 
md         .\skin\adminhtml\default\default\fonts\            
md         .\skin\adminhtml\default\default\images  
md         .\js\tbt           

REM rebuild links                
mklink /D  .\app\code\community\TBT\Enhancedgrid                  %source_path%\app\code\community\TBT\Enhancedgrid
mklink     .\app\design\adminhtml\default\default\layout\tbt_enhancedgrid.xml  %source_path%\app\design\adminhtml\default\default\layout\tbt_enhancedgrid.xml
mklink /D  .\app\design\adminhtml\default\default\template\tbt    %source_path%\app\design\adminhtml\default\default\template\tbt
mklink     .\app\design\frontend\default\default\layout\tbt_enhancedgrid.xml   %source_path%\app\design\frontend\default\default\layout\tbt_enhancedgrid.xml
mklink /D  .\app\design\frontend\default\default\template\tbt     %source_path%\app\design\frontend\default\default\template\tbt
mklink     .\app\etc\modules\TBT_Enhancedgrid.xml                          %source_path%\app\etc\modules\TBT_Enhancedgrid.xml
mklink /D  .\skin\frontend\default\default\css\enhancedgrid                %source_path%\skin\frontend\default\default\css\enhancedgrid
mklink /D  .\skin\frontend\default\default\images\enhancedgrid             %source_path%\skin\frontend\default\default\images\enhancedgrid
mklink /D  .\js\tbt\enhancedgrid               %source_path%\js\tbt\enhancedgrid  

popd           


pause
