import pyaudio
import numpy as np
RATE = 44100
FORMAT = pyaudio.paInt16
CHANNELS = 2

#Processing
CHUNK = 1024
CHIRP_PERIOD = 20 * 1E-3
DOPPLER_CALCULATION_PERIOD = CHIRP_PERIOD
NUMBER_OF_POINTS = int(DOPPLER_CALCULATION_PERIOD * RATE)
FREQ_CENTRAL = 2590 * 1E6
ZERO_PADDING = (NUMBER_OF_POINTS) / 2
DECIMATION_FACTOR = 80
WAVE_OUTPUT_FILENAME = "/temp_wav.wav"
WINDOW = np.hanning(NUMBER_OF_POINTS / 2.0)
#IP_SERVER = '104.236.221.13'
#IP_SERVER = '104.236.221.13'
IP_SERVER = '127.0.0.1'