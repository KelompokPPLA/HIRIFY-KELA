const Availability = require('../models/Availability');
const Booking = require('../models/Booking');

// Helper to check overlap
const isOverlap = (aStart, aEnd, bStart, bEnd) => {
  return !(aEnd <= bStart || bEnd <= aStart);
};

exports.createAvailability = async (req, res, next) => {
  try {
    const { date, startTime, endTime } = req.body;
    const mentorId = req.user._id;

    // fetch existing availabilities for date
    const existing = await Availability.find({ mentorId, date });
    for (const slot of existing) {
      if (isOverlap(startTime, endTime, slot.startTime, slot.endTime)) {
        return res.status(400).json({ success: false, message: 'Slot overlaps with existing availability' });
      }
    }

    const avail = await Availability.create({ mentorId, date, startTime, endTime });
    res.json({ success: true, data: avail });
  } catch (err) {
    next(err);
  }
};

exports.getAvailabilities = async (req, res, next) => {
  try {
    const mentorId = req.user._id;
    const avail = await Availability.find({ mentorId });
    res.json({ success: true, data: avail });
  } catch (err) { next(err); }
};

exports.updateAvailability = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { date, startTime, endTime } = req.body;
    const mentorId = req.user._id;

    const avail = await Availability.findOne({ _id: id, mentorId });
    if (!avail) return res.status(404).json({ success: false, message: 'Availability not found' });
    if (avail.isBooked) return res.status(400).json({ success: false, message: 'Cannot edit booked slot' });

    // check overlap
    const existing = await Availability.find({ mentorId, date, _id: { $ne: id } });
    for (const slot of existing) {
      if (isOverlap(startTime, endTime, slot.startTime, slot.endTime)) {
        return res.status(400).json({ success: false, message: 'Slot overlaps with existing availability' });
      }
    }

    avail.date = date; avail.startTime = startTime; avail.endTime = endTime;
    await avail.save();
    res.json({ success: true, data: avail });
  } catch (err) { next(err); }
};

exports.deleteAvailability = async (req, res, next) => {
  try {
    const { id } = req.params;
    const mentorId = req.user._id;
    const avail = await Availability.findOne({ _id: id, mentorId });
    if (!avail) return res.status(404).json({ success: false, message: 'Availability not found' });
    if (avail.isBooked) return res.status(400).json({ success: false, message: 'Cannot delete booked slot' });
    await avail.remove();
    res.json({ success: true, message: 'Deleted' });
  } catch (err) { next(err); }
};

exports.getBookings = async (req, res, next) => {
  try {
    const mentorId = req.user._id;
    const bookings = await Booking.find({ mentorId }).populate('menteeId', 'name email').populate('availabilityId');
    res.json({ success: true, data: bookings });
  } catch (err) { next(err); }
};

exports.acceptBooking = async (req, res, next) => {
  try {
    const { id } = req.params;
    const mentorId = req.user._id;
    const booking = await Booking.findOne({ _id: id, mentorId }).populate('availabilityId');
    if (!booking) return res.status(404).json({ success: false, message: 'Booking not found' });
    if (booking.status !== 'pending') return res.status(400).json({ success: false, message: 'Booking already processed' });

    // mark booking accepted and availability booked
    booking.status = 'accepted';
    await booking.save();
    const avail = await Availability.findById(booking.availabilityId._id);
    avail.isBooked = true;
    await avail.save();
    res.json({ success: true, data: booking });
  } catch (err) { next(err); }
};

exports.rejectBooking = async (req, res, next) => {
  try {
    const { id } = req.params;
    const mentorId = req.user._id;
    const booking = await Booking.findOne({ _id: id, mentorId });
    if (!booking) return res.status(404).json({ success: false, message: 'Booking not found' });
    if (booking.status !== 'pending') return res.status(400).json({ success: false, message: 'Booking already processed' });
    booking.status = 'rejected';
    await booking.save();
    res.json({ success: true, data: booking });
  } catch (err) { next(err); }
};
