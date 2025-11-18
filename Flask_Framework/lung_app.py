from flask import Flask, request, jsonify
import pickle
import pandas as pd
from flask_cors import CORS
import numpy as np
import warnings
warnings.filterwarnings("ignore", category=UserWarning) # Hide sklearn warnings about feature names

app = Flask(__name__)
CORS(app)

# --- 1. Load the Model ---
try:
    with open('../model/lung_cancer_prediction_model.pkl', 'rb') as file:
        model_pipeline = pickle.load(file)
    print("Lung Cancer Prediction Model Loaded Successfully.")
except FileNotFoundError:
    print("ERROR: 'lung_cancer_prediction_model.pkl' not found. Please train and save the model.")
    model_pipeline = None

# --- Define the expected column order for the model ---
FEATURE_ORDER = [
    'AGE', 'GENDER', 'SMOKING', 'FINGER_DISCOLORATION', 'MENTAL_STRESS', 
    'EXPOSURE_TO_POLLUTION', 'LONG_TERM_ILLNESS', 'ENERGY_LEVEL', 'IMMUNE_WEAKNESS', 
    'BREATHING_ISSUE', 'ALCOHOL_CONSUMPTION', 'THROAT_DISCOMFORT', 'OXYGEN_SATURATION', 
    'CHEST_TIGHTNESS', 'FAMILY_HISTORY', 'SMOKING_FAMILY_HISTORY', 'STRESS_IMMUNE'
]


@app.route('/lung_predict', methods=['POST'])
def lung_predict():
    if model_pipeline is None:
        return jsonify({'error': "Model not loaded. Check server logs."}), 500
        
    try:
        data = request.form
        
        # 1. Create a dictionary from the form data, converting to float/int
        input_data = {}
        for key in FEATURE_ORDER:
            # Handle continuous vs binary features based on input type
            if key in ['AGE', 'GENDER', 'SMOKING', 'FINGER_DISCOLORATION', 'MENTAL_STRESS', 
                       'EXPOSURE_TO_POLLUTION', 'LONG_TERM_ILLNESS', 'IMMUNE_WEAKNESS', 
                       'BREATHING_ISSUE', 'ALCOHOL_CONSUMPTION', 'THROAT_DISCOMFORT', 
                       'CHEST_TIGHTNESS', 'FAMILY_HISTORY', 'SMOKING_FAMILY_HISTORY', 'STRESS_IMMUNE']:
                input_data[key] = int(data[key])
            elif key in ['ENERGY_LEVEL', 'OXYGEN_SATURATION']:
                input_data[key] = float(data[key])
            else:
                input_data[key] = float(data[key]) # Default to float

        # 2. Convert to DataFrame in the correct order for the pipeline
        input_df = pd.DataFrame([input_data], columns=FEATURE_ORDER)
        
        # 3. Predict
        prediction = model_pipeline.predict(input_df)[0]
        
        # 4. Format Result (1 was 'YES', 0 was 'NO')
        result_text = "Positive (High Risk of Pulmonary Disease)" if prediction == 1 else "Negative (Low Risk of Pulmonary Disease)"

        # 5. Return JSON response
        return jsonify({'prediction_result': result_text})

    except Exception as e:
        print("Error during prediction:", e)
        # Log all data for debugging purposes
        print("Received Data:", dict(request.form)) 
        return jsonify({'error': f"Prediction failed due to bad input data or server error: {str(e)}"}), 400


if __name__ == '__main__':
    # You must run this Flask server before trying the PHP script
    app.run(host='0.0.0.0', port=10001, debug=True)