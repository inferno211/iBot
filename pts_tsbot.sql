CREATE TABLE `top10connections` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `connections` int(11) NOT NULL,
  `nick` text NOT NULL,
  `clid` int(11) NOT NULL
);


CREATE TABLE `top10connectiontime` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `connectiontime` int(11) NOT NULL,
  `nick` text NOT NULL,
  `clid` int(11) NOT NULL
);

CREATE TABLE `premium` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `endtime` int(11) NOT NULL,
  `nick` varchar(255) NOT NULL DEFAULT 'Brak'
);

ALTER TABLE `top10connections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `top10connectiontime`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `premium`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `top10connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `top10connectiontime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
