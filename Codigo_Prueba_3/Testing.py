from Recording import *
from Range_calculation import *
from rti import *
# Iniciando stream
record_test = stream()

#conectandose con el cliente para enviar json por mqtt
client = paho.Client()
#client.connect("104.236.221.13")
client.connect("localhost", port="1883")
client.loop_start()

while True:

    #testenado recording
    testing_recording = record_test.return_stream()

    #print "testing recording DATA"
    #print testing_recording/32768.0
    print "length data"
    print len(testing_recording)
    print "********************** End of testing recording... **********************"

    #testeando el procesamiento del audio
    print "\n\n\n *********** Start testing the precessing of the recording... ***********"
    #velocity_test = Range_calculation(testing_recording) #sin paho

    #data = velocity_test.return_range()

    print " ************** End of testing the precessing of the recording... ************** "

    test_range = Range_calculation(testing_recording,client)
    test_range.return_range()
    time.sleep(0.5)
    #print "\n\n\n *********** Start testing plots... *********** "
    #print data
    '''
    data.heights = data["heights"]
    data.times = data["time"]
    data = data.heights
    print data
    data.append(data.heights,data.time)

    print data["heights"]
    heights = np.asarray(data["heights"])
    times = np.asarray(data["times"])
    print data.shape
    #print data

    plot(data)
    '''
