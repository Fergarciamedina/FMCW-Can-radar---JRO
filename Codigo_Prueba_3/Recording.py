#import pyaudio
from constants import *
import wave
from scipy.io.wavfile import read


class stream():
    def __init__(self):
        print "initi"
        self.audio_recording = pyaudio.PyAudio()
        print "getting attributes"
        self.stream = self.audio_recording.open(format=FORMAT, channels=CHANNELS,
                                                rate=RATE, input=True,
                                                frames_per_buffer=NUMBER_OF_POINTS)
        print "the end"
        print CHANNELS
    def return_stream(self):

        ''' ********** Start Recording ********** '''
        print("* recording")
        frames = []
        print "analisis"
        print int(math.ceil(NUMBER_OF_POINTS * 1.0/ CHUNK)) # = 4 for chrip = 85 1E-3 || = 3 chirp = 20 1E-3 or 20 ms
        for i in range(0, 3 * int(math.ceil(NUMBER_OF_POINTS * 1.0/ CHUNK))):
            data = self.stream.read(CHUNK, exception_on_overflow = False)
            frames.append(data)
        print("* done recording")
        ''' ********** End of Recording ********** '''

        ''' no se para que configuran depues de grabar, talves en el siguiente loop
            para que todos los archivos tengan la misma condiguracion '''
        ''' ********** Setting audio file characteristics ********** '''
        wf = wave.open(WAVE_OUTPUT_FILENAME, 'wb')
        wf.setnchannels(CHANNELS)
        print "channels"
        print CHANNELS
        wf.setsampwidth(self.audio_recording.get_sample_size(FORMAT))
        print "setsampwidth"
        print self.audio_recording.get_sample_size(FORMAT)
        print "format"
        print FORMAT
        wf.setframerate(RATE)
        print "RATE"
        print RATE
        wf.writeframes(b''.join(frames))
        print "frames"
        #print frames
        wf.close()
        ''' ***************** End of the setting   ***************** '''

        ''' ********** Getting the data of the WAV file ********** '''
        [rate, data] = read(WAVE_OUTPUT_FILENAME, 'r') # estoy  cambiando WAVE_OUTPUT_FILENAME -> wav de prueba mit
        #data = data[:5 * NUMBER_OF_POINTS,:] # esto tampoco se para que lo han puesto
        ''' ********** Returd the data array - 2 columns, 2 channels ********** '''
        return data

    ''' ******************** Esto era usado en el java creo ******************** '''
    def stop_stream(self):
        self.stream.stop_stream()
        self.stream.close()
        self.audio_recording.terminate()
