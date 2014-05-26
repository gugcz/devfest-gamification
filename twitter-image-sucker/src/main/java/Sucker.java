import javax.imageio.ImageIO;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.net.URL;

import org.apache.commons.codec.binary.Base64;
import org.apache.commons.codec.digest.DigestUtils;
import org.apache.commons.io.FileUtils;
import org.imgscalr.Scalr;
import retrofit.mime.TypedString;

/**
 * Copyright (c) ${year}, Inmite s.r.o. (www.inmite.eu). All rights reserved.
 * <p/>
 * This source code can be used only for purposes specified by the given license contract
 * signed by the rightful deputy of Inmite s.r.o. This source code can be used only
 * by the owner of the license.
 * <p/>
 * Any disputes arising in respect of this agreement (license) shall be brought
 * before the Municipal Court of Prague.
 */
public class Sucker {

	static final String API_KEY = "r9Avumh1vHG19CF2XPWLTYn1p";
	static final String API_SECRET = "BeOkdXjhe7w6QVROHOpGvdLxDmUaRcivj5cIWvCwNPDx5z9gRI";

	public static void main(String[] args) {
		p("Welcome to Twitter Image Sucker!");
		p("Authenticating ...");
		TypedString grantType = new TypedString("grant_type=client_credentials");
		Authentication.Access access = Api.get().create(Authentication.class).authenticate(getEncodedKeys(), grantType);
		p("Downloading images ...");
		for (Data.Attendee attendee : Data.ATTENDEES) {
			File file = new File("output/" + attendee.id + ".jpg");
			File fileLarge = new File("output/136/" + attendee.id + ".jpg");
			if (file.exists()) {
				p("Image for " + attendee.id + " already exists");
			} else {
				try {
					if (attendee.twitter.isEmpty()) {
						String gravatarHash = calculateGravatarHash(attendee.email);
						p("GRAVATAR Image saved to" + file.getAbsolutePath());
						FileUtils.copyURLToFile(new URL("http://www.gravatar.com/avatar/" + gravatarHash + ".jpg?d=retro&s=30"), file);
						FileUtils.copyURLToFile(new URL("http://www.gravatar.com/avatar/" + gravatarHash + ".jpg?d=retro&s=136"), fileLarge);
					} else {
						Users.User user = Api.get().create(Users.class).show(getToken(access.access_token), attendee.twitter);
						p("TWITTER Image saved to" + file.getAbsolutePath());
						String profile_image_url = user.profile_image_url;
						p("Profile URL: "+profile_image_url);
						FileUtils.copyURLToFile(new URL(profile_image_url), file);
						resizeImage(file, 30);
						profile_image_url = profile_image_url.replace("_normal", "");
						FileUtils.copyURLToFile(new URL(profile_image_url), fileLarge);
						resizeImage(fileLarge, 136);
					}
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
		p("Sucker sucked the world successfully.");
	}

	private static String calculateGravatarHash(String email) {
		return DigestUtils.md5Hex(email.trim().toLowerCase());
	}

	private static void p(String text) {
		System.out.println(text);
	}

	private static String getEncodedKeys() {
		return "Basic " + Base64.encodeBase64String((API_KEY + ":" + API_SECRET).getBytes());
	}

	private static String getToken(String bearer) {
		return "Bearer " + bearer;
	}

	private static void resizeImage(File file, int size) {
		try {
			// scale image on disk
			BufferedImage originalImage = ImageIO.read(file);
			BufferedImage resizeImageJpg = Scalr.resize(originalImage, size);
			ImageIO.write(resizeImageJpg, "jpg", file);
		} catch (IOException e) {
			System.out.println(e.getMessage());
		}
	}
}
