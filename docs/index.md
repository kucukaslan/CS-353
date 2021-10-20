# CS 353  Database Management Systems Term Project

The Travel Agency Management System aims to keep the data available and maintain fine and efficient queries in the process.

The system will allow the user to store, retrieve, and modify data relating to tours, tour guides, hotel reservations, and other things. An authorization system will also be implemented such that it gives the employees the authority to change reservations and assign tour guides, while customers only have the authority to manage their own reservations and book a tour for themselves.

The database will support different types of users. The major ones are customers, tour guides, and employees. A customer can book a hotel room and reserve a tour if they wanted, while tour guides can accept or reject tour offers. Finally, Employees have the authority to change the reservation plans of a customer and assign certain tour guides to tours.

Each one of those users is identifiable by a unique ID.

For the tours and hotel reservation, tours can be uniquely identified by the tour guide ID and start time of the tour, a combination of these 2 attributes will always return a unique tuple. Reservations can also be uniquely identified by the customer ID and their stay date.

The final segment is about commenting, a customer can comment on their experience during the tour, likewise, a tour guide can comment on a tour after it has been concluded.

## People
* Ahmet Salman
* Güven Gergerli
* Muhammed Can Küçükaslan
* Mustafa Yasir Altunhan

## Reports
| [Proposal](./documents/proposal.pdf) | [Revised Proposal](./documents/proposal_revised.pdf) | [Final Report](./documents/final.pdf) |
| :---:         |     :---:      |          :---: |