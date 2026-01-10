@echo off
set FLASK_APP=diabetic_app.py
set FLASK_ENV=development
python -m flask run --port=10000
pause